<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function streamCustomerInvoice(int $id): \Illuminate\View\View
    {
        $customer = Customer::with(['user', 'service'])->findOrFail($id);
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

        $subtotal = $customer->service?->registration_fee ?? 0;
        $ppn = 0;
        $grandTotal = $subtotal + $ppn;
        
        return view('customer.invoice', compact('customer', 'subtotal', 'ppn', 'grandTotal'));
    }

    public function streamInvoice($id)
    {
        $customer = Customer::with(['user', 'baa', 'service', 'invoiceRegistrasi'])->findOrFail($id);

        if (!$customer->baa) {
            abort(404, 'BAA belum tersedia, Invoice belum dapat dicetak.');
        }
        
        $activationDate = Carbon::parse($customer->baa->activation_date);
        $trialEndDate = $activationDate->copy()->addDays(7);
        $prorateStartDate = $trialEndDate->copy()->addDay();
        $endOfMonth = $prorateStartDate->copy()->endOfMonth();
        
        $daysInMonth = $prorateStartDate->daysInMonth;
        $billableDays = $prorateStartDate->diffInDays($endOfMonth) + 1;

        $monthlyFee = $customer->service?->monthly_fee ?? 0;
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
        
        $pdf = Pdf::loadView('pdf.invoice-cetak', [
            'customer' => $customer,
            'invoiceData' => $invoiceData
        ]);
        
        $invoiceNumber = $customer->invoiceRegistrasi?->invoice_number ?? 'DRAFT';
        $namaFile = 'INV-' . str_replace('/', '-', $invoiceNumber) . '.pdf';
        
        return $pdf->stream($namaFile);
    }
}