<?php

namespace App\Livewire\Finance\Datapelanggan;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\On; 
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Finance - Data Pelanggan Aktif')]
#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;
    public $showModal = false;
    public $selectedCustomer = null;

    public $search = ''; 
    #[On('trigger-search')]
    public function updateSearch($query)
    {
        $this->search = $query;
        $this->resetPage(); 
    }

    // Fungsi membuka modal
    public function viewDetail($id)
    {
        $this->selectedCustomer = \App\Models\Customer::with(['user', 'spk', 'baa'])->find($id);
        $this->showModal = true;
    }

    // Fungsi menutup modal
    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedCustomer = null;
    }

    public function render()
    {
        $customers = Customer::with(['user', 'spk', 'baa'])
            ->where('status', 'selesai')
            ->where(function($query) {
                if ($this->search) {
                    $query->where('company_name', 'like', '%' . $this->search . '%')
                          ->orWhere('customer_number', 'like', '%' . $this->search . '%');
                }
            })
            ->latest()
            ->paginate(10);

        return view('livewire.finance.datapelanggan.index', [
            'customers' => $customers
        ]);
    }
}