<?php

namespace App\Http\Controllers;

use App\Models\CustomerService;
use App\Services\PdfAssetService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class InvoiceController extends Controller
{
    public function streamCustomerInvoice(int $id): \Illuminate\View\View
    {
        $service = CustomerService::with(['customer.user', 'invoiceRegistrasi'])->findOrFail($id);
        $customer = $service->customer;

        $user = auth()->user();
        $isCustomer = false;

        if ($user->role instanceof \App\Enums\Role) {
            $isCustomer = $user->role === \App\Enums\Role::Customer;
        } else {
            $isCustomer = strtolower($user->role) === 'customer';
        }

        if ($isCustomer && (int) $customer->user_id !== (int) $user->id) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE INVOICE INI.');
        }

        $subtotal = $service->registration_fee ?? 0;
        $ppn = 0;
        $grandTotal = $subtotal + $ppn;

        return view('customer.invoice', compact('customer', 'service', 'subtotal', 'ppn', 'grandTotal'));
    }

    public function streamInvoice(int $id): BinaryFileResponse
    {
        $service = CustomerService::with(['customer.user', 'baa', 'invoiceRegistrasi'])->findOrFail($id);
        $customer = $service->customer;

        $user = auth()->user();
        $isCustomer = false;

        if ($user->role instanceof \App\Enums\Role) {
            $isCustomer = $user->role === \App\Enums\Role::Customer;
        } else {
            $isCustomer = strtolower($user->role) === 'customer';
        }

        if ($isCustomer && (int) $customer->user_id !== (int) $user->id) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE INVOICE INI.');
        }

        if (! $service->baa) {
            abort(404, 'BAA belum tersedia, Invoice belum dapat dicetak.');
        }

        $activationDate = Carbon::parse($service->baa->activation_date);
        $trialEndDate = $activationDate->copy()->addDays(7);
        $prorateStartDate = $trialEndDate->copy()->addDay();
        $endOfMonth = $prorateStartDate->copy()->endOfMonth();

        $daysInMonth = $prorateStartDate->daysInMonth;
        $billableDays = $prorateStartDate->diffInDays($endOfMonth) + 1;

        $monthlyFee = $service->monthly_fee ?? 0;
        $prorateAmount = ($monthlyFee / $daysInMonth) * $billableDays;

        $ppn = $prorateAmount * 0.11;
        $grandTotal = $prorateAmount + $ppn;

        $invoiceData = [
            'activation_date' => $activationDate->format('d M Y'),
            'trial_end_date' => $trialEndDate->format('d M Y'),
            'prorate_start' => $prorateStartDate->format('d M Y'),
            'prorate_end' => $endOfMonth->format('d M Y'),
            'billable_days' => $billableDays,
            'days_in_month' => $daysInMonth,
            'monthly_fee' => $monthlyFee,
            'prorate_amount' => $prorateAmount,
            'ppn' => $ppn,
            'grand_total' => $grandTotal,
        ];

        $invoiceNumber = $service->invoiceRegistrasi?->invoice_number ?? 'DRAFT';
        $cachePath = "generated/invoices/v2/invoice-{$service->id}.pdf";

        if ($this->shouldRegenerate($service, $cachePath)) {
            Cache::lock("pdf-invoice-{$service->id}", 120)->block(10, function () use ($service, $customer, $prorateAmount, $ppn, $grandTotal, $invoiceData, $cachePath): void {
                if ($this->shouldRegenerate($service, $cachePath)) {
                    $pdf = Pdf::loadView('customer.invoice', [
                        'service' => $service,
                        'customer' => $customer,
                        'subtotal' => $prorateAmount,
                        'ppn' => $ppn,
                        'grandTotal' => $grandTotal,
                        'invoiceData' => $invoiceData,
                        'pdfLogoPath' => PdfAssetService::publicImagePath('logo/Logo MSS.png', 360),
                        'pdfFinanceSignaturePath' => PdfAssetService::publicImagePath('ttd/finance/ttdfinance.png', 420),
                    ])->setPaper('a4', 'portrait');

                    Storage::disk('local')->put($cachePath, $pdf->output());
                }
            });
        }

        $namaFile = 'INV-'.Str::slug($invoiceNumber).'.pdf';

        return response()->file(Storage::disk('local')->path($cachePath), [
            'Content-Disposition' => 'inline; filename="'.$namaFile.'"',
            'Content-Type' => 'application/pdf',
        ]);
    }

    private function shouldRegenerate(CustomerService $service, string $cachePath): bool
    {
        if (! Storage::disk('local')->exists($cachePath)) {
            return true;
        }

        $lastChangedAt = max(
            $service->updated_at?->timestamp ?? 0,
            $service->customer->updated_at?->timestamp ?? 0,
            $service->baa?->updated_at?->timestamp ?? 0,
            $service->invoiceRegistrasi?->updated_at?->timestamp ?? 0,
        );

        return Storage::disk('local')->lastModified($cachePath) < $lastChangedAt;
    }
}
