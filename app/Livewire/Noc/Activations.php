<?php

namespace App\Livewire\Noc;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('NOC - Aktivasi WiFi')]
#[Layout('layouts.app')]
class Activations extends Component
{
    use WithPagination;

    public function render(): \Illuminate\View\View
    {
        $customers = Customer::with('user')
            ->whereIn('status', [
                'pembayaran_disetujui',
                'proses_instalasi',
                'proses_aktivasi',
                'menunggu_baa',
                'baa_terbit',
            ])
            ->latest()
            ->paginate(10);

        return view('livewire.noc.activations', compact('customers'));
    }
}
