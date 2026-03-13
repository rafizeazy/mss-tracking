<?php

namespace App\Http\Controllers;

use App\Models\Customer;

class InvoiceController extends Controller
{
    public function streamCustomerInvoice(int $id): \Illuminate\View\View
    {
        $customer = Customer::with('user')->findOrFail($id);

        // Hanya pemilik invoice yang boleh melihat
        if ($customer->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke Invoice ini.');
        }

        $subtotal = ($customer->monthly_fee ?? 0) + ($customer->registration_fee ?? 0);
        $ppn = $subtotal * 0.11;
        $grandTotal = $subtotal + $ppn;

        return view('customer.invoice', compact('customer', 'subtotal', 'ppn', 'grandTotal'));
    }
}
