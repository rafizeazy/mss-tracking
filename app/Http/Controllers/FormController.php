<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function cetakFormulir($id)
    {
        $customer = Customer::with('user')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.formulir-berlangganan', [
            'customer' => $customer,
        ]);

        $pdf->setPaper('A4', 'portrait');

        $namaPerusahaanAtauOrang = $customer->company_name ?? $customer->user?->name;
        $fileName = 'FORMULIR-BERLANGGANAN-'.strtoupper(Str::slug($namaPerusahaanAtauOrang)).'.pdf';

        return $pdf->download($fileName);
    }
}
