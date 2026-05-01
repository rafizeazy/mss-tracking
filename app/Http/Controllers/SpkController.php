<?php

namespace App\Http\Controllers;

use App\Models\CustomerService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SpkController extends Controller
{
    public function streamSpk($id)
    {
        $service = CustomerService::with(['customer', 'spk'])->findOrFail($id);

        if (!$service->spk) {
            abort(404, 'SPK belum di-generate untuk layanan ini.');
        }

        $pdf = Pdf::loadView('pdf.spk', [
            'service' => $service,
            'customer' => $service->customer,
            'spk' => $service->spk,
        ]);

        return $pdf->stream('SPK-NOC-' . $service->customer->company_name . '.pdf');
    }
}