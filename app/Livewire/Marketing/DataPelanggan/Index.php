<?php

namespace App\Livewire\Marketing\DataPelanggan;

use App\Models\Customer;
use App\Events\CustomerUpdated;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
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

    #[On('trigger-search')]
    public function updateSearch($query)
    {
        $this->search = $query;
        $this->resetPage();
    }

    public function viewDetail($id)
    {
        $this->selectedCustomer = Customer::with(['user', 'spk', 'baa'])->find($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedCustomer = null;
    }

    public function openArsip($id)
    {
        $this->customerForArsip = Customer::with(['spk', 'baa'])->find($id);
        $this->showArsipModal = true;
    }

    public function closeArsip()
    {
        $this->showArsipModal = false;
        $this->customerForArsip = null;
    }

    public function editCustomer($id)
    {
        $customerToEdit = Customer::findOrFail($id);
        
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
            
            'service_type' => $customerToEdit->service_type,
            'bandwidth' => $customerToEdit->bandwidth,
            'term_of_service' => $customerToEdit->term_of_service,
            'jalur_metro' => $customerToEdit->jalur_metro,
            
            'registration_fee' => $customerToEdit->registration_fee,
            'monthly_fee' => $customerToEdit->monthly_fee,
            'marketing_name' => $customerToEdit->marketing_name,
            'marketing_phone' => $customerToEdit->marketing_phone,
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

        $customerToUpdate->update($this->editData);

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

    public function render()
    {
        $customers = Customer::with(['user', 'spk', 'baa'])
            ->where('status', 'selesai')
            ->where(function ($query) {
                if ($this->search) {
                    $query->where('company_name', 'like', '%'.$this->search.'%')
                        ->orWhere('customer_number', 'like', '%'.$this->search.'%');
                }
            })
            ->latest()
            ->paginate(10);

        return view('livewire.marketing.datapelanggan.index', [
            'customers' => $customers,
        ]);
    }
}
