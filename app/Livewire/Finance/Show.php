<?php

namespace App\Livewire\Finance;

use App\Events\CustomerUpdated;
use App\Mail\StatusPelangganBerubah;
use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\CustomerService;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Detail & Generate Invoice')]
#[Layout('layouts.app')]
class Show extends Component
{
    public CustomerService $service;

    public Customer $customer;

    public $showInvoicePreview = false;

    public $subtotal = 0;

    public $ppn = 0;

    public $grand_total = 0;

    public function mount($id)
    {
        $this->service = CustomerService::with(['customer.user', 'invoiceRegistrasi'])->findOrFail($id);
        $this->customer = $this->service->customer;
        $this->calculateTotals();
    }

    #[On('echo-private:mss-updates,CustomerUpdated')]
    public function refreshData()
    {
        $this->service->refresh();
        $this->customer->refresh();
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = $this->service->registration_fee ?? 0;
        $this->ppn = 0;
        $this->grand_total = $this->subtotal;
    }

    public function generatePreview()
    {
        if (! $this->service->invoiceRegistrasi || ! $this->service->invoiceRegistrasi->invoice_number) {
            $this->service->invoiceRegistrasi()->updateOrCreate(
                ['service_id' => $this->service->id],
                [
                    'invoice_number' => \App\Services\DocumentNumberService::generateInvoiceNumber(),
                    'invoice_generated_at' => now(),
                ]
            );
            $this->service->refresh();
        }

        ActivityLog::record('invoice.preview_generated', 'Preview invoice registrasi dibuat.', $this->customer);

        $this->showInvoicePreview = true;
    }

    public function sendInvoice()
    {
        $this->service->moveToStatus('menunggu_pembayaran');

        ActivityLog::record('invoice.sent', 'Invoice registrasi dikirim ke pelanggan.', $this->customer);

        broadcast(new CustomerUpdated);

        Mail::to($this->customer->user->email)
            ->queue(new StatusPelangganBerubah($this->customer, 'menunggu_pembayaran'));

        $this->customer->refresh();
        $this->dispatch('notify', type: 'success', message: 'Invoice Registrasi berhasil dikirim ke Dashboard Pelanggan! Menunggu pembayaran dari pelanggan.');
        $this->showInvoicePreview = false;
    }

    public function markAsFree()
    {
        $this->service->update([
            'registration_fee' => 0,
        ]);

        $this->service->moveToStatus('pembayaran_disetujui');

        ActivityLog::record('payment.free_marked', 'Biaya registrasi digratiskan oleh Finance.', $this->customer);

        broadcast(new CustomerUpdated);

        $this->service->refresh();
        $this->customer->refresh();
        $this->calculateTotals();

        $this->dispatch('notify', type: 'success', message: 'Biaya registrasi berhasil digratiskan. Layanan otomatis diteruskan ke tim NOC untuk proses instalasi.');
    }

    public function approvePayment()
    {
        $this->service->moveToStatus('pembayaran_disetujui');

        ActivityLog::record('payment.approved', 'Pembayaran pelanggan dikonfirmasi oleh Finance.', $this->customer);

        broadcast(new CustomerUpdated);

        $this->customer->refresh();
        $this->dispatch('notify', type: 'success', message: 'Pembayaran berhasil dikonfirmasi. Layanan akan dilanjutkan ke tahap Instalasi oleh tim NOC.');
    }

    public function rejectPayment()
    {
        $this->service->moveToStatus('menunggu_pembayaran');

        ActivityLog::record('payment.rejected', 'Bukti pembayaran ditolak oleh Finance.', $this->customer);

        broadcast(new CustomerUpdated);

        $this->customer->refresh();
        $this->dispatch('notify', type: 'error', message: 'Bukti pembayaran ditolak. Pelanggan telah diminta untuk mengunggah ulang bukti transfer yang valid.');
    }

    public function render()
    {
        return view('livewire.finance.tracking.show');
    }
}
