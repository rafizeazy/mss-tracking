<?php

namespace App\Livewire\Marketing\Tracking;

use App\Events\CustomerUpdated;
use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail Tracking Registrasi')]
#[Layout('layouts.app')]
class Show extends Component
{
    public Customer $customer;

    // Variabel Form Verifikasi
    public $service_type;
    public $bandwidth; 
    public $monthly_fee;
    public $registration_fee;
    public $sla = '99.5%';
    public $marketing_name;
    public $marketing_phone;

    // Variabel Form SPK
    public $job_type = 'Aktivasi Baru';
    public $customer_type = '';
    public $due_date;
    public $spk_notes = 'Tim NOC diminta untuk melakukan proses provisioning layanan sesuai detail di atas, termasuk konfigurasi perangkat jaringan, aktivasi layanan, serta memastikan konektivitas layanan berjalan dengan baik sebelum dilakukan serah terima kepada pelanggan.';

    // Variabel Modal Edit Data Master
    public $isEditingCustomer = false;
    public $editData = [];

    public function mount($id)
    {
        $this->customer = Customer::with(['user', 'spk'])->findOrFail($id);
        
        $this->service_type = $this->customer->service_type;
        $this->bandwidth = $this->customer->bandwidth; 
        $this->marketing_name = auth()->user()->name;

        if ($this->customer->spk) {
            $this->job_type = $this->customer->spk->job_type;
            $this->customer_type = $this->customer->spk->customer_type;
            $this->due_date = $this->customer->spk->due_date;
            $this->spk_notes = $this->customer->spk->notes;
        }
    }

    #[On('echo:mss-updates,CustomerUpdated')]
    public function refreshData()
    {
        $this->customer->refresh();
    }

    public function editCustomer()
    {
        $this->editData = [
            'ktp_number' => $this->customer->ktp_number,
            'gender' => $this->customer->gender,
            'position' => $this->customer->position,
            'phone' => $this->customer->phone,
            
            'company_name' => $this->customer->company_name,
            'business_type' => $this->customer->business_type,
            'npwp_number' => $this->customer->npwp_number,
            'company_phone' => $this->customer->company_phone,
            'company_address' => $this->customer->company_address,
            'city' => $this->customer->city,
            'province' => $this->customer->province,
            'postal_code' => $this->customer->postal_code,
            
            'finance_name' => $this->customer->finance_name,
            'finance_email' => $this->customer->finance_email, 
            'finance_phone' => $this->customer->finance_phone,
            'billing_address' => $this->customer->billing_address,
            
            'technical_name' => $this->customer->technical_name,
            'technical_email' => $this->customer->technical_email, 
            'technical_phone' => $this->customer->technical_phone,
            'installation_address' => $this->customer->installation_address,
            
            'service_type' => $this->customer->service_type,
            'bandwidth' => $this->customer->bandwidth,
            'term_of_service' => $this->customer->term_of_service,
        ];
        $this->isEditingCustomer = true;
    }

    public function updateCustomer()
    {
        $this->validate([
            'editData.ktp_number' => 'nullable|string',
            'editData.gender' => 'nullable|in:L,P',
            'editData.position' => 'nullable|string',
            'editData.phone' => 'required|string|max:20',
            
            'editData.company_name' => 'required|string|max:255',
            'editData.business_type' => 'nullable|string',
            'editData.npwp_number' => 'nullable|string',
            'editData.company_phone' => 'nullable|string|max:20',
            'editData.company_address' => 'required|string',
            'editData.city' => 'nullable|string',
            'editData.province' => 'nullable|string',
            'editData.postal_code' => 'nullable|string',
            
            'editData.finance_name' => 'nullable|string|max:255',
            'editData.finance_email' => 'nullable|email|max:255', 
            'editData.finance_phone' => 'nullable|string|max:20',
            'editData.billing_address' => 'nullable|string',
            
            'editData.technical_name' => 'nullable|string|max:255',
            'editData.technical_email' => 'nullable|email|max:255', 
            'editData.technical_phone' => 'nullable|string|max:20',
            'editData.installation_address' => 'nullable|string',
            
            'editData.service_type' => 'required|string',
            'editData.bandwidth' => 'required|string', 
            'editData.term_of_service' => 'nullable|numeric',
        ]);

        $this->customer->update($this->editData);

        broadcast(new CustomerUpdated());
        $this->customer->refresh();

        $this->isEditingCustomer = false;
        $this->dispatch('notify', type: 'success', message: 'Seluruh data profil pelanggan berhasil diperbarui!');
    }

    public function cancelEdit()
    {
        $this->isEditingCustomer = false;
    }

    public function approve()
    {
        $this->validate([
            'service_type' => 'required|string|max:255',
            'bandwidth' => 'required|string|max:255', 
            'monthly_fee' => 'required|numeric|min:0',
            'registration_fee' => 'required|numeric|min:0',
            'sla' => 'required|string|max:50',
            'marketing_name' => 'required|string|max:255',
            'marketing_phone' => 'required|string|max:20',
        ]);

        $this->customer->update([
            'service_type' => $this->service_type,
            'bandwidth' => $this->bandwidth, 
            'monthly_fee' => $this->monthly_fee,
            'registration_fee' => $this->registration_fee,
            'sla' => $this->sla,
            'marketing_name' => $this->marketing_name,
            'marketing_phone' => $this->marketing_phone,
            'status' => 'menunggu_invoice'
        ]);

        broadcast(new CustomerUpdated());

        $this->dispatch('notify', type: 'success', message: 'Data registrasi disetujui. Tagihan otomatis diteruskan ke Finance.');
    }

    public function reject()
    {
        $this->customer->update([
            'status' => 'ditolak'
        ]);

        broadcast(new CustomerUpdated());
        $this->dispatch('notify', type: 'error', message: 'Data registrasi pendaftar telah ditolak.');
    }

    public function saveSpkData()
    {
        $this->validate([
            'job_type' => 'required|string',
            'customer_type' => 'required|in:Government,Corporate',
            'due_date' => 'required|date',
            'spk_notes' => 'required|string',
        ]);

        $spkNumber = $this->customer->spk->spk_number ?? \App\Services\DocumentNumberService::generateSpkNumber();

        $this->customer->spk()->updateOrCreate(
            ['customer_id' => $this->customer->id],
            [
                'spk_number' => $spkNumber,
                'job_type' => $this->job_type,
                'customer_type' => $this->customer_type,
                'due_date' => $this->due_date,
                'notes' => $this->spk_notes,
            ]
        );

        $this->customer->refresh();

        broadcast(new CustomerUpdated());
        $this->dispatch('notify', type: 'success', message: 'Data SPK berhasil disimpan. Anda dapat mengecek PDF SPK sekarang.');
    }

    public function sendToNoc()
    {
        if (!$this->customer->spk) {
            $this->dispatch('notify', type: 'error', message: 'Harap simpan data SPK terlebih dahulu sebelum mengirim ke NOC.');
            return;
        }

        $this->customer->update([
            'status' => 'proses_instalasi'
        ]);

        broadcast(new CustomerUpdated());
        $this->dispatch('notify', type: 'success', message: 'SPK berhasil dikirim! Status layanan kini berada di tangan tim NOC.');
    }

    public function approveBaa()
    {
        $this->customer->update(['status' => 'selesai']);

        broadcast(new CustomerUpdated());
        $this->dispatch('notify', type: 'success', message: 'BAA disetujui! Layanan pelanggan telah resmi selesai dan aktif sepenuhnya.');
    }

    public function rejectBaa()
    {
        $this->customer->baa->update(['signed_baa_path' => null]);
        $this->customer->update(['status' => 'menunggu_baa']);

        broadcast(new CustomerUpdated());
        $this->dispatch('notify', type: 'error', message: 'BAA ditolak. Pelanggan telah diminta untuk menandatangani ulang.');
    }

    public function render()
    {
        return view('livewire.marketing.tracking.show');
    }
}