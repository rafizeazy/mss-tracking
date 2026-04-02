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
        $customer = Customer::with('user')->findOrFail($id);
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

        $subtotal = $customer->registration_fee ?? 0;
        $ppn = 0;
        $grandTotal = $subtotal + $ppn;
        return view('customer.invoice', compact('customer', 'subtotal', 'ppn', 'grandTotal'));
    }
    public function streamInvoice($id)
    {
        // Ambil data pelanggan beserta BAA-nya
        $customer = Customer::with(['user', 'baa'])->findOrFail($id);

        if (!$customer->baa) {
            abort(404, 'BAA belum tersedia, Invoice belum dapat dicetak.');
        }

        // Hitung ulang Prorate untuk ditampilkan di PDF
        $activationDate = Carbon::parse($customer->baa->activation_date);
        $trialEndDate = $activationDate->copy()->addDays(7);
        $prorateStartDate = $trialEndDate->copy()->addDay();
        $endOfMonth = $prorateStartDate->copy()->endOfMonth();
        
        $daysInMonth = $prorateStartDate->daysInMonth;
        $billableDays = $prorateStartDate->diffInDays($endOfMonth) + 1;

        $monthlyFee = $customer->monthly_fee ?? 0;
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

        // Me-render view PDF yang sudah kita buat sebelumnya
        $pdf = Pdf::loadView('pdf.invoice-cetak', [
            'customer' => $customer,
            'invoiceData' => $invoiceData
        ]);

        // Mengatur format kertas F4 (Opsional, gunakan A4 jika lebih suka standar)
        // $pdf->setPaper([0, 0, 609.4488, 935.433], 'portrait'); 

        // Menampilkan PDF di browser (stream)
        $namaFile = 'INV-' . str_replace('/', '-', $customer->invoice_number ?? 'DRAFT') . '.pdf';
        return $pdf->stream($namaFile);
    }
}