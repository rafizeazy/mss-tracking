<?php

namespace App\Http\Controllers;

use App\Models\CustomerService;
use Barryvdh\DomPDF\Facade\Pdf;

class BaaController extends Controller
{
    public function streamBaa($id)
    {
        $service = CustomerService::with(['customer', 'baa', 'spk'])->findOrFail($id);

        if (! $service->baa) {
            abort(404, 'Berita Acara Aktivasi (BAA) belum diterbitkan untuk layanan ini.');
        }

        $pdf = Pdf::loadView('pdf.baa', [
            'customer' => $service->customer,
            'service' => $service,
            'baa' => $service->baa,
            'spk' => $service->spk,
        ]);

        $safeCompanyName = str_replace(['/', '\\'], '-', $service->customer->company_name);
        $safeBaaNumber = str_replace(['/', '\\'], '-', $service->baa->baa_number);

        $filename = 'BAA-'.$safeCompanyName.'-'.$safeBaaNumber.'.pdf';

        return $pdf->stream($filename);
    }
}
