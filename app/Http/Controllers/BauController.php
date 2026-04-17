<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class BauController extends Controller
{
    public function streamBau($id)
    {
        $request = ServiceRequest::with(['customer.user', 'bau'])->findOrFail($id);
        
        $pdf = Pdf::loadView('pdf.bau', ['request' => $request]);
        
        return $pdf->stream('BAU_' . $request->request_number . '.pdf');
    }
}