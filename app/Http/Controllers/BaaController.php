<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\CustomerService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class BaaController extends Controller
{
    public function streamBaa(int $id): Response
    {
        $service = CustomerService::with(['customer.user', 'baa', 'spk'])->findOrFail($id);
        $user = auth()->user();

        $userRole = $user->role instanceof Role
            ? $user->role
            : Role::tryFrom($user->role);

        if ($userRole === Role::Customer && (int) $service->customer->user_id !== (int) $user->id) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE BAA INI.');
        }

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
