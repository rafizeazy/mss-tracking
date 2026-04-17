<?php

namespace App\Livewire\Berhenti;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Arsip Pelanggan Berhenti')]
#[Layout('layouts.app')]
class Berhenti extends Component
{
    use WithPagination;

    public $search = '';
    
    // Properti untuk Modal Detail
    public $showModal = false;
    public $selectedCustomer = null;
    
    // Properti untuk Modal Arsip
    public $showArsipModal = false;
    public $customerForArsip = null;

    // Reset pagination saat pencarian
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

    public function render()
    {
        // 1. Ambil HANYA pelanggan yang statusnya 'berhenti'
        $customers = Customer::with('user')
            ->where('status', 'berhenti')
            ->where(function($query) {
                if ($this->search) {
                    $query->where('company_name', 'like', '%' . $this->search . '%')
                          ->orWhere('customer_number', 'like', '%' . $this->search . '%');
                }
            })
            ->latest('updated_at') // Urutkan berdasarkan tanggal berhenti terbaru
            ->paginate(10);

        // 2. Dinamisasi Route Tombol Kembali (Agar sesuai dengan Divisi yang login)
        $role = auth()->user()->role;
        $roleValue = is_object($role) ? $role->value : $role; // Support untuk Enum
        
        // Contoh: Jika yang login 'marketing', maka jadi 'marketing.datapelanggan.index'
        $backRoute = $roleValue . '.datapelanggan.index';

        return view('livewire.berhenti.berhenti', [
            'customers' => $customers,
            'backRoute' => $backRoute
        ]);
    }
}