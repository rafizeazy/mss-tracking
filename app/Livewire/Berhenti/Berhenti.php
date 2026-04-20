<?php

namespace App\Livewire\Berhenti;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Arsip Pelanggan Berhenti')]
#[Layout('layouts.app')]
class Berhenti extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $selectedCustomer = null;
    public $showArsipModal = false;
    public $customerForArsip = null;

    public $showReactivateModal = false;
    public $customerToReactivate = null;

    public $showDeleteModal = false;
    public $customerToDelete = null;

    #[On('echo:mss-updates,CustomerUpdated')]
    public function refreshData()
    {
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function viewDetail($id)
    {
        $this->selectedCustomer = Customer::with(['user', 'spk', 'baa'])->findOrFail($id);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedCustomer = null;
    }

    public function openArsip($id)
    {
        $this->customerForArsip = Customer::findOrFail($id);
        $this->showArsipModal = true;
    }

    public function closeArsip()
    {
        $this->showArsipModal = false;
        $this->customerForArsip = null;
    }

    public function confirmReactivate($id)
    {
        $this->customerToReactivate = Customer::findOrFail($id);
        $this->showReactivateModal = true;
    }

    public function reactivateCustomer()
    {
        if ($this->customerToReactivate) {
            $this->customerToReactivate->update([
                'status' => 'selesai'
            ]);
            
            $this->dispatch('notify', type: 'success', message: 'Layanan pelanggan berhasil diaktifkan kembali!');
            
            $this->showReactivateModal = false;
            $this->customerToReactivate = null;
        }
    }

    // Fungsi untuk membuka modal konfirmasi hapus
    public function confirmDelete($id)
    {
        $this->customerToDelete = Customer::findOrFail($id);
        $this->showDeleteModal = true;
    }

    // Fungsi untuk mengeksekusi penghapusan
    public function deleteCustomer()
    {
        if ($this->customerToDelete) {
            $this->customerToDelete->delete();
            
            $this->dispatch('notify', type: 'success', message: 'Data pelanggan berhasil dihapus secara permanen!');
            
            $this->showDeleteModal = false;
            $this->customerToDelete = null;
        }
    }

    public function render()
    {
        $customers = Customer::with('user')
            ->where('status', 'berhenti')
            ->where(function($query) {
                if ($this->search) {
                    $query->where('company_name', 'like', '%' . $this->search . '%')
                          ->orWhere('customer_number', 'like', '%' . $this->search . '%');
                }
            })
            ->latest('updated_at') 
            ->paginate(10);

        $role = auth()->user()->role;
        $roleValue = is_object($role) ? $role->value : $role; 
        
        $backRoute = $roleValue . '.datapelanggan.index';

        return view('livewire.berhenti.berhenti', [
            'customers' => $customers,
            'backRoute' => $backRoute
        ]);
    }
}