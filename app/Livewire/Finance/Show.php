<?php

namespace App\Livewire\Finance;

use App\Events\CustomerUpdated;
use App\Mail\StatusPelangganBerubah;
use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\CustomerService;
use App\Services\DocumentNumberService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Throwable;

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

    public function mount($id): void
    {
        $this->service = CustomerService::with(['customer.user', 'invoiceRegistrasi'])->findOrFail($id);
        $this->customer = $this->service->customer;
        $this->calculateTotals();
    }

    #[On('echo-private:mss-updates,CustomerUpdated')]
    public function refreshData(): void
    {
        $this->service->refresh();
        $this->customer->refresh();
        $this->calculateTotals();
    }

    public function calculateTotals(): void
    {
        $this->subtotal = $this->service->registration_fee ?? 0;
        $this->ppn = 0;
        $this->grand_total = $this->subtotal;
    }

    public function generatePreview(): void
    {
        $this->withUniqueDocumentRetry(function (): void {
            DB::transaction(function (): void {
                $this->service->load('invoiceRegistrasi');

                if (! $this->service->invoiceRegistrasi || ! $this->service->invoiceRegistrasi->invoice_number) {
                    $this->service->invoiceRegistrasi()->updateOrCreate(
                        ['service_id' => $this->service->id],
                        [
                            'invoice_number' => DocumentNumberService::generateInvoiceNumber(),
                            'invoice_generated_at' => now(),
                        ]
                    );
                }
            });
        });

        $this->service->refresh();
        $this->service->load('invoiceRegistrasi');

        $this->recordActivitySafely('invoice.preview_generated', 'Preview invoice registrasi dibuat.');

        $this->showInvoicePreview = true;
    }

    public function sendInvoice(): void
    {
        $this->service->moveToStatus('menunggu_pembayaran');

        $this->recordActivitySafely('invoice.sent', 'Invoice registrasi dikirim ke pelanggan.');

        $this->broadcastCustomerUpdatedSafely();

        Mail::to($this->customer->user->email)
            ->queue(new StatusPelangganBerubah($this->customer, 'menunggu_pembayaran'));

        $this->customer->refresh();
        $this->dispatch('notify', type: 'success', message: 'Invoice Registrasi berhasil dikirim ke Dashboard Pelanggan! Menunggu pembayaran dari pelanggan.');
        $this->showInvoicePreview = false;
    }

    public function markAsFree(): void
    {
        $this->service->update([
            'registration_fee' => 0,
        ]);

        $this->service->moveToStatus('pembayaran_disetujui');

        $this->recordActivitySafely('payment.free_marked', 'Biaya registrasi digratiskan oleh Finance.');

        $this->broadcastCustomerUpdatedSafely();

        $this->service->refresh();
        $this->customer->refresh();
        $this->calculateTotals();

        $this->dispatch('notify', type: 'success', message: 'Biaya registrasi berhasil digratiskan. Layanan otomatis diteruskan ke tim NOC untuk proses instalasi.');
    }

    public function approvePayment(): void
    {
        $this->service->moveToStatus('pembayaran_disetujui');

        $this->recordActivitySafely('payment.approved', 'Pembayaran pelanggan dikonfirmasi oleh Finance.');

        $this->broadcastCustomerUpdatedSafely();

        $this->customer->refresh();
        $this->dispatch('notify', type: 'success', message: 'Pembayaran berhasil dikonfirmasi. Layanan akan dilanjutkan ke tahap Instalasi oleh tim NOC.');
    }

    public function rejectPayment(): void
    {
        $this->service->moveToStatus('menunggu_pembayaran');

        $this->recordActivitySafely('payment.rejected', 'Bukti pembayaran ditolak oleh Finance.');

        $this->broadcastCustomerUpdatedSafely();

        $this->customer->refresh();
        $this->dispatch('notify', type: 'error', message: 'Bukti pembayaran ditolak. Pelanggan telah diminta untuk mengunggah ulang bukti transfer yang valid.');
    }

    public function render(): mixed
    {
        return view('livewire.finance.tracking.show');
    }

    private function withUniqueDocumentRetry(callable $callback): void
    {
        for ($attempt = 1; $attempt <= 3; $attempt++) {
            try {
                $callback();

                return;
            } catch (QueryException $exception) {
                if ($attempt === 3 || ! $this->isUniqueConstraintViolation($exception)) {
                    throw $exception;
                }

                $this->service->refresh();
            }
        }
    }

    private function isUniqueConstraintViolation(QueryException $exception): bool
    {
        return in_array((string) $exception->getCode(), ['23000', '23505'], true);
    }

    private function recordActivitySafely(string $action, string $description): void
    {
        try {
            ActivityLog::record($action, $description, $this->customer);
        } catch (Throwable $exception) {
            Log::warning('Activity log failed during finance tracking action.', [
                'action' => $action,
                'customer_id' => $this->customer->id,
                'exception' => $exception->getMessage(),
            ]);
        }
    }

    private function broadcastCustomerUpdatedSafely(): void
    {
        try {
            broadcast(new CustomerUpdated);
        } catch (Throwable $exception) {
            Log::warning('Customer update broadcast failed during finance tracking action.', [
                'customer_id' => $this->customer->id,
                'exception' => $exception->getMessage(),
            ]);
        }
    }
}
