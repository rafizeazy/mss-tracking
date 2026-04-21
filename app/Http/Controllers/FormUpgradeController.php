<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Services\PerubahanLayananNumberService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FormUpgradeController extends Controller
{
    public function previewRequestPdf($id)
    {
        $request = ServiceRequest::with('customer.user')->findOrFail($id);
        $formNumber = PerubahanLayananNumberService::generate($request);
        
        $pdf = Pdf::loadView('pdf.formpermintaan', [
            'request' => $request,
            'formNumber' => $formNumber 
        ]);
        
        return $pdf->stream('Formulir_Perubahan_Layanan_' . $request->request_number . '.pdf');
    }

    public function previewSpkPdf($id)
{
    $request = ServiceRequest::with('customer.user')->findOrFail($id);
    $spkNumber = PerubahanLayananNumberService::generateSpk($request);
    
    $pdf = Pdf::loadView('pdf.spkpermintaan', [
        'request' => $request,
        'spkNumber' => $spkNumber
    ]);
    
    return $pdf->stream('SPK_' . $request->request_number . '.pdf');
}
}