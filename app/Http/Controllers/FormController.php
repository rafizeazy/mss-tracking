<?php

namespace App\Http\Controllers;

use App\Models\CustomerService;
use App\Services\PdfAssetService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FormController extends Controller
{
    public function cetakFormulir(int $id): BinaryFileResponse
    {
        $service = CustomerService::with('customer.user')->findOrFail($id);
        $customer = $service->customer;

        $cachePath = "generated/forms/v2/formulir-{$service->id}.pdf";

        if ($this->shouldRegenerate($service, $cachePath)) {
            Cache::lock("pdf-formulir-{$service->id}", 120)->block(10, function () use ($service, $customer, $cachePath): void {
                if ($this->shouldRegenerate($service, $cachePath)) {
                    $pdf = Pdf::loadView('pdf.formulir-berlangganan', [
                        'service' => $service,
                        'customer' => $customer,
                        'pdfLogoPath' => PdfAssetService::publicImagePath('logo/Logo MSS.png', 360),
                        'pdfMarketingSignaturePath' => PdfAssetService::publicImagePath('ttd/marketing/ttdmarketing.png', 420),
                    ])->setPaper('a4', 'portrait');

                    Storage::disk('local')->put($cachePath, $pdf->output());
                }
            });
        }

        $namaPerusahaanAtauOrang = $customer->company_name ?? $customer->user?->name;
        $fileName = 'FORMULIR-BERLANGGANAN-'.strtoupper(Str::slug($namaPerusahaanAtauOrang)).'.pdf';

        return response()->file(Storage::disk('local')->path($cachePath), [
            'Content-Disposition' => 'inline; filename="'.$fileName.'"',
            'Content-Type' => 'application/pdf',
        ]);
    }

    private function shouldRegenerate(CustomerService $service, string $cachePath): bool
    {
        if (! Storage::disk('local')->exists($cachePath)) {
            return true;
        }

        $lastChangedAt = max(
            $service->updated_at?->timestamp ?? 0,
            $service->customer->updated_at?->timestamp ?? 0,
            $service->customer->user?->updated_at?->timestamp ?? 0,
        );

        return Storage::disk('local')->lastModified($cachePath) < $lastChangedAt;
    }
}
