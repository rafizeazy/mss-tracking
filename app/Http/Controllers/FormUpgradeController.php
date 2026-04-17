<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FormUpgradeController extends Controller
{
    public function previewRequestPdf($id)
    {
        $request = ServiceRequest::with('customer.user')->findOrFail($id);
        
        $pdf = Pdf::loadView('pdf.formpermintaan', ['request' => $request]);
        
        return $pdf->stream('Formulir_Perubahan_Layanan_' . $request->request_number . '.pdf');
    }

    public function previewSpkPdf($id)
    {
        $request = ServiceRequest::with('customer.user')->findOrFail($id);
        
        $pdf = Pdf::loadView('pdf.spkpermintaan', ['request' => $request]);
        
        return $pdf->stream('SPK_' . $request->request_number . '.pdf');
    }
}