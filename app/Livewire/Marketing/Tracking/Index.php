<?php

namespace App\Livewire\Marketing\Tracking;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Tracking Registrasi Pelanggan')]
#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $showCancelled = false;

    #[On('trigger-search')]
    public function updateSearch($query)
    {
        $this->search = $query;
        $this->resetPage();
    }
    
    public function toggleCancelled()
    {
        $this->showCancelled = !$this->showCancelled;
        $this->resetPage();
    }

    #[On('echo:mss-updates,CustomerUpdated')]
    public function refreshData()
    {
    }

    public function render()
    {
        $query = Customer::with(['user', 'service', 'invoiceRegistrasi', 'baa']);
        
        if ($this->showCancelled) {
            $query->whereIn('status', ['dibatalkan', 'ditolak']);
        } else {
            $query->whereNotIn('status', ['selesai', 'berhenti', 'dibatalkan', 'ditolak']);
        }

        $customers = $query->where(function($q) {
                if ($this->search) {
                    $q->where('company_name', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                }
            })
            ->latest()
            ->paginate(10);

        return view('livewire.marketing.tracking.index', [
            'customers' => $customers
        ]);
    }
}