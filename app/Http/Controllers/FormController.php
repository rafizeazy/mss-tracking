<?php

namespace App\Http\Controllers;

use App\Models\CustomerService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function cetakFormulir($id)
    {
        $service = CustomerService::with('customer.user')->findOrFail($id);
        $customer = $service->customer;

        $pdf = Pdf::loadView('pdf.formulir-berlangganan', [
            'service' => $service,
            'customer' => $customer
        ]);

        $pdf->setPaper('A4', 'portrait');

        $namaPerusahaanAtauOrang = $customer->company_name ?? $customer->user->name;
        $fileName = 'FORMULIR-BERLANGGANAN-' . strtoupper(Str::slug($namaPerusahaanAtauOrang)) . '.pdf';

        return $pdf->stream($fileName);
    }
}