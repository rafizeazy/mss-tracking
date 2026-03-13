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

    public function viewInvoice()
    {
        session()->flash('info', 'File Invoice (PDF) sedang dalam proses pembuatan. Fitur cetak akan segera tersedia.');
    }

    public function uploadPayment()
    {
        $this->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);
        $path = $this->payment_proof->store('payment_proofs', 'public');
        $this->customer->update([
            'payment_proof_file_path' => $path,
            'status' => 'verifikasi_pembayaran'
        ]);

        session()->flash('success', 'Bukti transfer berhasil dikirim! Menunggu verifikasi dari tim Finance kami.');
        
        // Reset state
        $this->payment_proof = null;
    }

    public function render()
    {
        return view('livewire.customer.dashboard');
    }
}