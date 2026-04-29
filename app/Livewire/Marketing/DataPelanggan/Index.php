<?php

namespace App\Livewire\Marketing\Datapelanggan;

use App\Models\Customer;
use App\Events\CustomerUpdated;
use Illuminate\Support\Arr;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Marketing - Data Pelanggan Aktif')]
#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $showModal = false;
    public $selectedCustomer = null;

    public $isEditingCustomer = false;
    public $editData = [];

    public $showArsipModal = false;
    public $customerForArsip = null;

    // Menambahkan properti untuk mengontrol tampilan tab pelanggan berhenti
    public $showBerhentiOnly = false;

    #[On('trigger-search')]
    public function updateSearch($query)
    {
        $this->search = $query;
        $this->resetPage();
    }

    public function viewDetail($id)
    {
        $this->selectedCustomer = Customer::with(['user', 'spk', 'baa', 'service'])->find($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedCustomer = null;
    }

    public function openArsip($id)
    {
        $this->customerForArsip = Customer::with(['spk', 'baa', 'service'])->find($id);
        $this->showArsipModal = true;
    }

    public function closeArsip()
    {
        $this->showArsipModal = false;
        $this->customerForArsip = null;
    }

    public function editCustomer($id)
    {
        $customerToEdit = Customer::with('service')->findOrFail($id);
        
        $this->editData = [
            'ktp_number' => $customerToEdit->ktp_number,
            'gender' => $customerToEdit->gender,
            'position' => $customerToEdit->position,
            'phone' => $customerToEdit->phone,
            
            'company_name' => $customerToEdit->company_name,
            'business_type' => $customerToEdit->business_type,
            'npwp_number' => $customerToEdit->npwp_number,
            'company_phone' => $customerToEdit->company_phone,
            'company_address' => $customerToEdit->company_address,
            'city' => $customerToEdit->city,
            'province' => $customerToEdit->province,
            'postal_code' => $customerToEdit->postal_code,
            
            'finance_name' => $customerToEdit->finance_name,
            'finance_email' => $customerToEdit->finance_email, 
            'finance_phone' => $customerToEdit->finance_phone,
            'billing_address' => $customerToEdit->billing_address,
            
            'technical_name' => $customerToEdit->technical_name,
            'technical_email' => $customerToEdit->technical_email, 
            'technical_phone' => $customerToEdit->technical_phone,
            'installation_address' => $customerToEdit->installation_address,
            
            'service_type' => $customerToEdit->service->service_type ?? '',
            'bandwidth' => $customerToEdit->service->bandwidth ?? '',
            'term_of_service' => $customerToEdit->service->term_of_service ?? '',
            'jalur_metro' => $customerToEdit->service->jalur_metro ?? '',
            
            'registration_fee' => $customerToEdit->service->registration_fee ?? '',
            'monthly_fee' => $customerToEdit->service->monthly_fee ?? '',
            'marketing_name' => $customerToEdit->service->marketing_name ?? '',
            'marketing_phone' => $customerToEdit->service->marketing_phone ?? '',
        ];
        
        $this->isEditingCustomer = true;
    }

    public function updateCustomer()
    {
        if (!$this->selectedCustomer && !$this->isEditingCustomer) return;
        
        $customerId = $this->selectedCustomer ? $this->selectedCustomer->id : Customer::where('phone', $this->editData['phone'])->first()->id;
        $customerToUpdate = Customer::find($customerId);

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
            'editData.jalur_metro' => 'nullable|string',
            'editData.registration_fee' => 'nullable|numeric',
            'editData.monthly_fee' => 'nullable|numeric',
            'editData.marketing_name' => 'nullable|string|max:255',
            'editData.marketing_phone' => 'nullable|string|max:20',
        ]);

        $updateData = Arr::except($this->editData, [
            'service_type', 'bandwidth', 'term_of_service', 'jalur_metro', 
            'registration_fee', 'monthly_fee', 'marketing_name', 'marketing_phone'
        ]);

        $serviceData = Arr::only($this->editData, [
            'service_type', 'bandwidth', 'term_of_service', 'jalur_metro', 
            'registration_fee', 'monthly_fee', 'marketing_name', 'marketing_phone'
        ]);

        $serviceData['registration_fee'] = empty($serviceData['registration_fee']) ? 0 : $serviceData['registration_fee'];
        $serviceData['monthly_fee']      = empty($serviceData['monthly_fee']) ? 0 : $serviceData['monthly_fee'];
        $serviceData['term_of_service']  = empty($serviceData['term_of_service']) ? null : $serviceData['term_of_service'];

        $customerToUpdate->update($updateData);

        $customerToUpdate->service()->updateOrCreate(
            ['customer_id' => $customerToUpdate->id],
            $serviceData
        );

        if(class_exists(CustomerUpdated::class)) {
            broadcast(new CustomerUpdated());
        }
        
        if($this->selectedCustomer) $this->selectedCustomer->refresh();

        $this->isEditingCustomer = false;
        $this->dispatch('notify', type: 'success', message: 'Arsip data pelanggan berhasil diperbarui!');
    }

    public function cancelEdit()
    {
        $this->isEditingCustomer = false;
    }

    // Fungsi Baru: Memberhentikan Pelanggan
    public function berhentikanPelanggan($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update(['status' => 'berhenti']);

        if(class_exists(CustomerUpdated::class)) {
            broadcast(new CustomerUpdated());
        }

        $this->dispatch('notify', type: 'success', message: 'Status pelanggan berhasil diubah menjadi Berhenti.');
    }

    public function render()
    {
        // Kondisi Query diperbarui berdasarkan status toggle
        $statusToFetch = $this->showBerhentiOnly ? 'berhenti' : 'selesai';

        $customers = Customer::with(['user', 'spk', 'baa', 'service'])
            ->where('status', $statusToFetch)
            ->where(function($query) {
                if ($this->search) {
                    $query->where('company_name', 'like', '%' . $this->search . '%')
                          ->orWhere('customer_number', 'like', '%' . $this->search . '%');
                }
            })
            ->latest()
            ->paginate(10);

        return view('livewire.marketing.datapelanggan.index', [
            'customers' => $customers
        ]);
    }
}