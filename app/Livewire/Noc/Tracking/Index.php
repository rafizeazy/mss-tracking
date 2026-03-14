<?php

namespace App\Livewire\Noc\Tracking;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('NOC - Tracking SPK Instalasi')]
#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $customers = Customer::with(['user', 'spk'])
            ->whereIn('status', [
                'proses_instalasi', 
                'proses_aktivasi', 
                'review_baa',      
                'menunggu_baa', 
                'verifikasi_baa'  
            ])
            ->latest()
            ->paginate(10);

        return view('livewire.noc.tracking.index', [
            'customers' => $customers
        ]);
    }
}