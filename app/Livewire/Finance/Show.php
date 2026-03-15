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
        $this->customer = Customer::with('user')->findOrFail($id);
        $this->calculateTotals();
    }

    #[On('echo:mss-updates,CustomerUpdated')]
    public function refreshData()
    {
        $this->customer->refresh();
    }

    public function calculateTotals()
    {
        $this->subtotal = $this->customer->registration_fee;
        $this->ppn = 0;
        $this->grand_total = $this->subtotal;
    }

    public function generatePreview()
    {
        $this->showInvoicePreview = true;
    }

    public function sendInvoice()
    {
        $this->customer->update([
            'status' => 'menunggu_pembayaran'
        ]);
        
        broadcast(new CustomerUpdated());
        
        $this->customer->refresh(); 
        
        session()->flash('success', 'Invoice Registrasi berhasil dikirim ke Dashboard Pelanggan! Menunggu pembayaran dari pelanggan.');
        $this->showInvoicePreview = false;
    }

    public function approvePayment()
    {
        $this->customer->update([
            'status' => 'pembayaran_disetujui'
        ]);

        broadcast(new CustomerUpdated());

        $this->customer->refresh(); 
        
        session()->flash('success', 'Pembayaran berhasil dikonfirmasi. Layanan akan dilanjutkan ke tahap Instalasi oleh tim NOC.');
    }

    public function rejectPayment()
    {
        $this->customer->update([
            'status' => 'menunggu_pembayaran'
        ]);

        broadcast(new CustomerUpdated());

        $this->customer->refresh(); 
        
        session()->flash('error', 'Bukti pembayaran ditolak. Pelanggan telah diminta untuk mengunggah ulang bukti transfer yang valid.');
    }

    public function render()
    {
        return view('livewire.finance.tracking.show');
    }
}