<?php

namespace App\Http\Controllers;

use App\Models\CustomerService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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

        if ($isCustomer && $customer->user_id !== $user->id) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE INVOICE INI.');
        }

        $subtotal = $service->registration_fee ?? 0;
        $ppn = 0;
        $grandTotal = $subtotal + $ppn;

        return view('customer.invoice', compact('customer', 'service', 'subtotal', 'ppn', 'grandTotal'));
    }

    public function streamInvoice($id)
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

        if ($isCustomer && $customer->user_id !== $user->id) {
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

        $pdf = Pdf::loadView('customer.invoice', [
            'service' => $service,
            'customer' => $customer,
            'subtotal' => $prorateAmount,
            'ppn' => $ppn,
            'grandTotal' => $grandTotal,
            'invoiceData' => $invoiceData,
        ]);

        $invoiceNumber = $service->invoiceRegistrasi?->invoice_number ?? 'DRAFT';
        $namaFile = 'INV-'.str_replace('/', '-', $invoiceNumber).'.pdf';

        return $pdf->stream($namaFile);
    }
}
