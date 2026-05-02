<?php

namespace App\Livewire\Finance;

use App\Models\CustomerService;
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

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[On('trigger-search')]
    public function updateSearch($query): void
    {
        $this->search = $query;
        $this->resetPage();
    }

    #[On('echo-private:mss-updates,CustomerUpdated')]
    public function refreshData()
    {
    }

    public function render()
    {
        $services = CustomerService::with(['customer.user', 'invoiceRegistrasi'])
            ->whereHas('customer', function ($query) {
                $query->whereIn('status', [
                    'menunggu_invoice', 
                    'menunggu_pembayaran', 
                    'verifikasi_pembayaran', 
                    'pembayaran_disetujui', 
                    'proses_instalasi', 
                    'proses_aktivasi', 
                    'review_baa',      
                    'menunggu_baa', 
                    'verifikasi_baa'
                ]);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($sub) {
                    $sub->whereHas('customer', function ($q) {
                        $q->where('company_name', 'like', '%' . $this->search . '%');
                    })->orWhereHas('invoiceRegistrasi', function ($q) {
                        $q->where('invoice_number', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.finance.tracking.index', [
            'services' => $services
        ]);
    }
}
