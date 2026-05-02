<?php

namespace App\Livewire\Customer;

use App\Events\CustomerUpdated;
use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Dashboard Pelanggan')]
#[Layout('layouts.app')]
class Dashboard extends Component
{
    use WithFileUploads;

    public $signed_baa;
    public ?Customer $customer = null;
    public $payment_proof;

    public function mount()
    {
        $this->loadCustomer();
    }

    #[On('echo-private:mss-updates,CustomerUpdated')]
    public function loadCustomer()
    {
        $this->customer = Customer::with(['baa', 'service', 'invoiceRegistrasi'])
            ->where('user_id', auth()->id())
            ->latest()
            ->first();
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
        
        if ($this->customer->invoiceRegistrasi) {
            $this->customer->invoiceRegistrasi->update([
                'payment_proof_file_path' => $path,
            ]);
        }
        
        $this->customer->update([
            'status' => 'verifikasi_pembayaran',
        ]);

        broadcast(new CustomerUpdated());

        $this->dispatch('toast', type: 'success', title: 'Bukti Terkirim!', message: 'Bukti transfer berhasil dikirim. Menunggu verifikasi.');
        
        $this->payment_proof = null;
        $this->loadCustomer(); 
    }

    public function uploadSignedBaa()
    {
        $this->validate([
            'signed_baa' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $path = $this->signed_baa->store('baa/signed', 'public');
        
        if ($this->customer->baa) {
            $this->customer->baa->update(['signed_baa_path' => $path]);
        }

        $this->customer->update(['status' => 'verifikasi_baa']);

        broadcast(new CustomerUpdated());

        $this->signed_baa = null;
        $this->loadCustomer();
        $this->dispatch('toast', type: 'success', title: 'Upload Berhasil!', message: 'BAA telah dikirim ke tim Marketing untuk diverifikasi akhir.');
    }

    public function render()
    {
        return view('livewire.customer.dashboard');
    }
}
