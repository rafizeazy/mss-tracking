<?php

namespace App\Livewire\Noc\Tracking;

use App\Models\Customer;
use App\Events\CustomerUpdated;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Detail Pekerjaan NOC')]
#[Layout('layouts.app')]
class Show extends Component
{
    use WithFileUploads;

    public Customer $customer;
    
    public $customer_number;
    public $noc_name;
    public $noc_position = 'NETWORK OPERATION CENTER';
    public $noc_department = 'OPERATION';
    public $noc_location = 'KARAWANG';
    public $activation_date;
    
    public $noc_signature;
    public $speedtest_image;
    public $devices = [];

    public $isEditingBaa = false; 

    public function mount($id)
    {
        $this->customer = Customer::with(['user', 'spk', 'baa'])->findOrFail($id);
        $this->customer_number = $this->customer->customer_number;
        $this->noc_name = auth()->user()->name;
        $this->activation_date = date('Y-m-d');

        if (empty($this->devices)) {
            $this->devices[] = ['name' => '', 'qty' => 1, 'sn' => ''];
        }
    }

    public function addDevice() { $this->devices[] = ['name' => '', 'qty' => 1, 'sn' => '']; }
    
    public function removeDevice($index) { 
        unset($this->devices[$index]); 
        $this->devices = array_values($this->devices); 
    }

    public function finishInstallation()
    {
        $this->customer->update(['status' => 'proses_aktivasi']);
        
        broadcast(new CustomerUpdated());
        
        $this->customer->refresh();
        $this->dispatch('notify', type: 'success', message: 'Instalasi fisik selesai. Silakan isi form BAA untuk aktivasi.');
    }

    public function editBaa()
    {
        $this->isEditingBaa = true;
        $baa = $this->customer->baa;
        if ($baa) {
            $this->noc_name = $baa->noc_name;
            $this->noc_position = $baa->noc_position;
            $this->noc_department = $baa->noc_department;
            $this->noc_location = $baa->noc_location;
            $this->activation_date = $baa->activation_date->format('Y-m-d');
            $this->devices = $baa->devices;
        }
    }

    public function finishActivation()
    {
        $rules = [
            'customer_number' => 'required|string|unique:customers,customer_number,' . $this->customer->id,
            'noc_name' => 'required|string',
            'noc_position' => 'required|string',
            'noc_department' => 'required|string',
            'noc_location' => 'required|string',
            'activation_date' => 'required|date',
            'devices.*.name' => 'required|string',
            'devices.*.qty' => 'required|numeric|min:1',
            'devices.*.sn' => 'required|string',
        ];
        if (!$this->customer->baa || $this->noc_signature) $rules['noc_signature'] = 'required|image|max:1024';
        if (!$this->customer->baa || $this->speedtest_image) $rules['speedtest_image'] = 'required|image|max:2048';

        $this->validate($rules);

        $existingBaa = $this->customer->baa;
        $signaturePath = $existingBaa?->noc_signature_path;
        $speedtestPath = $existingBaa?->speedtest_image_path;

        if ($this->noc_signature) $signaturePath = $this->noc_signature->store('baa/signatures', 'public');
        if ($this->speedtest_image) $speedtestPath = $this->speedtest_image->store('baa/speedtests', 'public');

        // Memanggil layanan penomoran dokumen otomatis
        $baaNumber = $existingBaa?->baa_number ?? \App\Services\DocumentNumberService::generateBaaNumber();

        $this->customer->baa()->updateOrCreate(
            ['customer_id' => $this->customer->id],
            [
                'spk_id' => $this->customer->spk->id,
                'baa_number' => $baaNumber,
                'noc_name' => $this->noc_name,
                'noc_position' => $this->noc_position,
                'noc_department' => $this->noc_department,
                'noc_location' => $this->noc_location,
                'activation_date' => $this->activation_date,
                'noc_signature_path' => $signaturePath,
                'speedtest_image_path' => $speedtestPath,
                'devices' => $this->devices,
            ]
        );

        $this->customer->update([
            'customer_number' => $this->customer_number,
            'status' => 'review_baa' 
        ]);

        broadcast(new CustomerUpdated());

        $this->isEditingBaa = false;
        $this->customer->refresh();
        $this->dispatch('notify', type: 'success', message: 'BAA berhasil di-generate! Silakan periksa PDF-nya sebelum dikirim ke pelanggan.');
    }

    public function sendBaaToCustomer()
    {
        $this->customer->update(['status' => 'menunggu_baa']);
        
        broadcast(new CustomerUpdated());
        
        $this->customer->refresh();
        $this->dispatch('notify', type: 'success', message: 'BAA berhasil dikirim ke Dashboard Pelanggan untuk ditandatangani.');
    }

    public function render()
    {
        return view('livewire.noc.tracking.show');
    }
}