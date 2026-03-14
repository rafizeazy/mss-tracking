<?php

namespace App\Http\Controllers;

use App\Models\Customer;

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
}