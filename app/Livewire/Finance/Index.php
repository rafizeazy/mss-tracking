<?php

namespace App\Livewire\Finance;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Finance - Tracking Tagihan')]
#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    #[On('trigger-search')]
    public function updateSearch($query)
    {
        $this->search = $query;
        $this->resetPage(); 
    }

    #[On('echo:mss-updates,CustomerUpdated')]
    public function refreshData()
    {
    }

    public function render()
    {
        $customers = Customer::with(['user', 'service', 'invoiceRegistrasi'])
            ->whereIn('status', [
                'menunggu_invoice', 
                'menunggu_pembayaran', 
                'verifikasi_pembayaran', 
                'pembayaran_disetujui', 
                'proses_instalasi', 
                'proses_aktivasi', 
                'review_baa',      
                'menunggu_baa', 
                'verifikasi_baa'
            ])
            ->where(function($query) {
                if ($this->search) {
                    $query->where('company_name', 'like', '%' . $this->search . '%')
                          ->orWhereHas('invoiceRegistrasi', function($q) {
                              $q->where('invoice_number', 'like', '%' . $this->search . '%');
                          });
                }
            })
            ->latest()
            ->paginate(10);

        return view('livewire.finance.tracking.index', [
            'customers' => $customers
        ]);
    }
}