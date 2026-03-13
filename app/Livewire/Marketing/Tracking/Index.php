<?php

namespace App\Livewire\Marketing\Tracking;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Tracking Registrasi Pelanggan')]
#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public function render()
    {
        // Mengambil semua data pelanggan, diurutkan dari yang terbaru
        // with('user') digunakan untuk mengambil relasi nama pendaftar secara efisien
        $customers = Customer::with('user')->latest()->paginate(10);

        return view('livewire.marketing.tracking.index', [
            'customers' => $customers
        ]);
    }
}