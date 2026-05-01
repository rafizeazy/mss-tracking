<?php

namespace App\Livewire\Noc\Tracking;

use App\Models\CustomerService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\On; 
use Livewire\Component;
use Livewire\WithPagination;

#[Title('NOC - Tracking SPK Instalasi')]
#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    #[On('echo:mss-updates,CustomerUpdated')]
    public function refreshTabel()
    {
    }

    public function render()
    {
        $services = CustomerService::with(['customer.user', 'spk', 'baa'])
            ->whereHas('customer', function ($query) {
                $query->whereIn('status', [
                    'proses_instalasi', 
                    'proses_aktivasi', 
                    'review_baa',      
                    'menunggu_baa', 
                    'verifikasi_baa'  
                ]);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.noc.tracking.index', [
            'services' => $services
        ]);
    }
}