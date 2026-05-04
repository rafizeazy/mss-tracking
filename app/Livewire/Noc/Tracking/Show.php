<?php

namespace App\Livewire\Noc\Tracking;

use App\Events\CustomerUpdated;
use App\Mail\StatusPelangganBerubah;
use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\CustomerService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Detail Pekerjaan NOC')]
#[Layout('layouts.app')]
class Show extends Component
{
    use WithFileUploads;

    public CustomerService $service;

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

    public bool $showFinishInstallationModal = false;

    public bool $showSendBaaModal = false;

    public function mount($id)
    {
        $this->service = CustomerService::with(['customer.user', 'spk', 'baa'])->findOrFail($id);
        $this->customer = $this->service->customer;

        $this->customer_number = $this->customer->customer_number;
        $this->noc_name = auth()->user()->name;
        $this->activation_date = date('Y-m-d');

        if (empty($this->devices)) {
            $this->devices[] = ['name' => '', 'qty' => 1, 'sn' => ''];
        }
    }

    public function addDevice()
    {
        $this->devices[] = ['name' => '', 'qty' => 1, 'sn' => ''];
    }

    public function removeDevice($index)
    {
        unset($this->devices[$index]);
        $this->devices = array_values($this->devices);
    }

    public function openFinishInstallationModal(): void
    {
        $this->showFinishInstallationModal = true;
    }

    public function closeFinishInstallationModal(): void
    {
        $this->showFinishInstallationModal = false;
    }

    public function openSendBaaModal(): void
    {
        $this->showSendBaaModal = true;
    }

    public function closeSendBaaModal(): void
    {
        $this->showSendBaaModal = false;
    }

    public function finishInstallation()
    {
        $this->customer->update(['status' => 'proses_aktivasi']);

        ActivityLog::record('installation.finished', 'Instalasi fisik selesai oleh NOC.', $this->customer);

        broadcast(new CustomerUpdated);

        $this->showFinishInstallationModal = false;
        $this->customer->refresh();
        $this->dispatch('notify', type: 'success', message: 'Instalasi fisik selesai. Silakan isi form BAA untuk aktivasi.');
    }

    public function editBaa()
    {
        $this->isEditingBaa = true;
        $baa = $this->service->baa;
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
            'customer_number' => 'required|string|unique:customers,customer_number,'.$this->customer->id,
            'noc_name' => 'required|string',
            'noc_position' => 'required|string',
            'noc_department' => 'required|string',
            'noc_location' => 'required|string',
            'activation_date' => 'required|date',
            'devices.*.name' => 'required|string',
            'devices.*.qty' => 'required|numeric|min:1',
            'devices.*.sn' => 'required|string',
        ];
        if (! $this->service->baa || $this->noc_signature) {
            $rules['noc_signature'] = 'required|image|max:1024';
        }
        if (! $this->service->baa || $this->speedtest_image) {
            $rules['speedtest_image'] = 'required|image|max:2048';
        }

        $this->validate($rules);

        $signaturePath = $this->service->baa?->noc_signature_path;
        $speedtestPath = $this->service->baa?->speedtest_image_path;

        if ($this->noc_signature) {
            $signaturePath = $this->noc_signature->store('baa/signatures', 'public');
        }
        if ($this->speedtest_image) {
            $speedtestPath = $this->speedtest_image->store('baa/speedtests', 'public');
        }

        $baaNumber = $this->service->baa?->baa_number ?? \App\Services\DocumentNumberService::generateBaaNumber();

        $this->service->baa()->updateOrCreate(
            ['service_id' => $this->service->id],
            [
                'spk_id' => $this->service->spk->id,
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

        $this->forgetBaaPdfCache();

        $this->customer->update([
            'customer_number' => $this->customer_number,
            'status' => 'review_baa',
            'status_reason' => null,
            'status_reason_at' => null,
        ]);

        ActivityLog::record('baa.generated', 'BAA dibuat atau diperbarui oleh NOC.', $this->customer);

        broadcast(new CustomerUpdated);

        $this->isEditingBaa = false;
        $this->customer->refresh();
        $this->service->refresh();
        $this->dispatch('notify', type: 'success', message: 'BAA berhasil di-generate! Silakan periksa PDF-nya sebelum dikirim ke pelanggan.');
    }

    public function sendBaaToCustomer()
    {
        $this->customer->update(['status' => 'menunggu_baa']);

        ActivityLog::record('baa.sent_to_customer', 'BAA dikirim ke pelanggan untuk ditandatangani.', $this->customer);

        broadcast(new CustomerUpdated);

        Mail::to($this->customer->user->email)
            ->queue(new StatusPelangganBerubah($this->customer, 'menunggu_baa'));

        $this->showSendBaaModal = false;
        $this->customer->refresh();
        $this->dispatch('notify', type: 'success', message: 'BAA berhasil dikirim ke Dashboard Pelanggan untuk ditandatangani.');
    }

    public function render()
    {
        return view('livewire.noc.tracking.show');
    }

    private function forgetBaaPdfCache(): void
    {
        Storage::disk('local')->delete("generated/baa/baa-{$this->service->id}.pdf");
    }
}
