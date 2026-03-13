<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Dashboard Pelanggan')]
#[Layout('layouts.app')]
class Dashboard extends Component
{
    use WithFileUploads;

    public Customer $customer;

    public $payment_proof;

    public function mount()
    {
        $this->customer = Customer::where('user_id', auth()->id())->latest()->first();
    }

    public function viewInvoice(): void
    {
        $this->dispatch('toast', type: 'info', title: 'Info', message: 'Fitur cetak Invoice akan segera tersedia.');
    }

    public function uploadPayment()
    {
        $this->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);
        $path = $this->payment_proof->store('payment_proofs', 'public');
        $this->customer->update([
            'payment_proof_file_path' => $path,
            'status' => 'verifikasi_pembayaran',
        ]);

        $this->dispatch('toast', type: 'success', title: 'Bukti Terkirim!', message: 'Bukti transfer berhasil dikirim. Menunggu verifikasi dari tim Finance kami.');
        $this->payment_proof = null;
    }

    public function render()
    {
        return view('livewire.customer.dashboard');
    }
}
