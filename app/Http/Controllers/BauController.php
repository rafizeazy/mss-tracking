<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Services\BauNumberService;
use Barryvdh\DomPDF\Facade\Pdf;

class BauController extends Controller
{
    public function streamBau($id)
    {
        $request = ServiceRequest::with(['customer.user', 'bau'])->findOrFail($id);
        
        $bauNumber = $request->bau ? BauNumberService::generate($request->bau) : '-';
        
        $pdf = Pdf::loadView('pdf.bau', [
            'request' => $request,
            'bauNumber' => $bauNumber
        ]);
        
        return $pdf->stream('BAU_' . $request->request_number . '.pdf');
    }
}