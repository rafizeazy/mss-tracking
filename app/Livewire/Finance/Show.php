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

    public function sendInvoice(): void
    {
        $invoiceNumber = 'INV-REG-'.date('Ymd').'-'.str_pad($this->customer->id, 3, '0', STR_PAD_LEFT);

        $this->customer->update([
            'invoice_number' => $invoiceNumber,
            'invoice_generated_at' => now(),
        ]);

        $this->dispatch('toast', type: 'success', title: 'Invoice Terkirim', message: 'Invoice '.$invoiceNumber.' berhasil dikirim ke Dashboard Pelanggan.');
        $this->showInvoicePreview = false;
    }

    public function approvePayment()
    {
        $this->customer->update([
            'status' => 'pembayaran_disetujui',
        ]);
        $this->dispatch('toast', type: 'success', title: 'Pembayaran Dikonfirmasi', message: 'Pembayaran valid. Layanan dilanjutkan ke tim NOC untuk proses instalasi.');
    }

    public function rejectPayment()
    {
        $this->customer->update([
            'status' => 'menunggu_pembayaran',
        ]);
        $this->dispatch('toast', type: 'error', title: 'Pembayaran Ditolak', message: 'Bukti pembayaran ditolak. Pelanggan diminta mengunggah ulang bukti transfer yang valid.');
    }

    public function render()
    {
        return view('livewire.finance.tracking.show');
    }
}
