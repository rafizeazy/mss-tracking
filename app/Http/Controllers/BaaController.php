<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;

class BaaController extends Controller
{
    public function streamBaa($id)
    {
        $customer = Customer::with(['baa', 'spk', 'service'])->findOrFail($id);

        if (!$customer->baa) {
            abort(404, 'Berita Acara Aktivasi (BAA) belum diterbitkan.');
        }

        $pdf = Pdf::loadView('pdf.baa', ['customer' => $customer]);
        
        return $pdf->stream('BAA-' . $customer->company_name . '.pdf');
    }
}