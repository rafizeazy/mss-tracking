<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SpkController extends Controller
{
    public function streamSpk($id)
    {
        $customer = Customer::with('spk')->findOrFail($id);

        if (!$customer->spk) {
            abort(404, 'SPK belum di-generate untuk pelanggan ini.');
        }

        $pdf = Pdf::loadView('pdf.spk', [
            'customer' => $customer,
        ]);

        return $pdf->stream('SPK-NOC-' . $customer->company_name . '.pdf');
    }
}