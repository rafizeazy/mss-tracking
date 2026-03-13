<?php

namespace App\Livewire\Finance;

use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail & Generate Invoice')]
#[Layout('layouts.app')]
class Show extends Component
{
    public Customer $customer;
    public $showInvoicePreview = false;
    
    public $subtotal = 0;
    public $ppn = 0;
    public $grand_total = 0;

    public function mount($id)
    {
        $this->customer = Customer::with('user')->findOrFail($id);
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = $this->customer->monthly_fee + $this->customer->registration_fee;
        $this->ppn = $this->subtotal * 0.11;
        $this->grand_total = $this->subtotal + $this->ppn;
    }

    public function generatePreview()
    {
        $this->showInvoicePreview = true;
    }

    public function sendInvoice()
    {
        session()->flash('success', 'Invoice Registrasi berhasil dikirim ke Dashboard Pelanggan! Menunggu pembayaran dari pelanggan.');
        $this->showInvoicePreview = false;
    }

    public function approvePayment()
    {
        $this->customer->update([
            'status' => 'pembayaran_disetujui'
        ]);
        session()->flash('success', 'Pembayaran berhasil dikonfirmasi. Layanan akan dilanjutkan ke tahap Instalasi oleh tim NOC.');
    }

    public function rejectPayment()
    {
        $this->customer->update([
            'status' => 'menunggu_pembayaran'
        ]);
        session()->flash('error', 'Bukti pembayaran ditolak. Pelanggan telah diminta untuk mengunggah ulang bukti transfer yang valid.');
    }

    public function render()
    {
        return view('livewire.finance.tracking.show');
    }
}