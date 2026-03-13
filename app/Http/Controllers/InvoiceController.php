<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function streamCustomerInvoice($id)
    {
        $customer = Customer::findOrFail($id);
        if ($customer->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke Invoice ini.');
        }
        $subtotal = $customer->monthly_fee + $customer->registration_fee;
        $ppn = $subtotal * 0.11;
        $grand_total = $subtotal + $ppn;

        // Render PDF
        $pdf = Pdf::loadView('pdf.invoice', [
            'customer' => $customer,
            'subtotal' => $subtotal,
            'ppn' => $ppn,
            'grand_total' => $grand_total,
        ]);
        return $pdf->stream('Invoice-Registrasi-MSS-' . str_pad($customer->id, 3, '0', STR_PAD_LEFT) . '.pdf');
    }
}