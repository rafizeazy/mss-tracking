<?php

namespace App\Livewire\Finance;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Finance - Tracking Tagihan')]
#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $customers = Customer::with('user')
            ->whereIn('status', [
                'menunggu_pembayaran', 
                'verifikasi_pembayaran', 
                'pembayaran_disetujui', 
                'proses_instalasi', 
                'proses_aktivasi', 
                'menunggu_baa', 
                'baa_terbit', 
                'selesai'
            ])
            ->latest()
            ->paginate(10);

        return view('livewire.finance.tracking.index', [
            'customers' => $customers
        ]);
    }
}