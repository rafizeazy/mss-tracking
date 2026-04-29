<?php

namespace App\Livewire\Finance;

use App\Events\CustomerUpdated;
use App\Models\Customer;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
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
        $this->customer = Customer::with(['user', 'service', 'invoiceRegistrasi'])->findOrFail($id);
        $this->calculateTotals();
    }

    #[On('echo:mss-updates,CustomerUpdated')]
    public function refreshData()
    {
        $this->customer->refresh();
    }

    public function calculateTotals()
    {
        $this->subtotal = $this->customer->service?->registration_fee ?? 0;
        $this->ppn = 0;
        $this->grand_total = $this->subtotal;
    }

    public function generatePreview()
    {
        if (!$this->customer->invoiceRegistrasi || !$this->customer->invoiceRegistrasi->invoice_number) {
            $this->customer->invoiceRegistrasi()->updateOrCreate(
                ['customer_id' => $this->customer->id],
                [
                    'invoice_number' => \App\Services\DocumentNumberService::generateInvoiceNumber(),
                    'invoice_generated_at' => now()
                ]
            );
            $this->customer->refresh();
        }

        $this->showInvoicePreview = true;
    }

    public function sendInvoice()
    {
        $this->customer->update([
            'status' => 'menunggu_pembayaran'
        ]);
        
        broadcast(new CustomerUpdated());
        
        $this->customer->refresh(); 
        $this->dispatch('notify', type: 'success', message: 'Invoice Registrasi berhasil dikirim ke Dashboard Pelanggan! Menunggu pembayaran dari pelanggan.');
        $this->showInvoicePreview = false;
    }

    public function markAsFree()
    {
        $this->customer->service()->update([
            'registration_fee' => 0,
        ]);

        $this->customer->update([
            'status' => 'pembayaran_disetujui'
        ]);

        broadcast(new CustomerUpdated());

        $this->customer->refresh();
        $this->calculateTotals();
        
        $this->dispatch('notify', type: 'success', message: 'Biaya registrasi berhasil digratiskan. Layanan otomatis diteruskan ke tim NOC untuk proses instalasi.');
    }

    public function approvePayment()
    {
        $this->customer->update([
            'status' => 'pembayaran_disetujui'
        ]);

        broadcast(new CustomerUpdated());

        $this->customer->refresh(); 
        $this->dispatch('notify', type: 'success', message: 'Pembayaran berhasil dikonfirmasi. Layanan akan dilanjutkan ke tahap Instalasi oleh tim NOC.');
    }

    public function rejectPayment()
    {
        $this->customer->update([
            'status' => 'menunggu_pembayaran'
        ]);

        broadcast(new CustomerUpdated());

        $this->customer->refresh(); 
        $this->dispatch('notify', type: 'error', message: 'Bukti pembayaran ditolak. Pelanggan telah diminta untuk mengunggah ulang bukti transfer yang valid.');
    }

    public function render()
    {
        return view('livewire.finance.tracking.show');
    }
}