<?php

namespace App\Http\Controllers;

use App\Models\CustomerService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SpkController extends Controller
{
    public function streamSpk(int $id): BinaryFileResponse
    {
        $service = CustomerService::with(['customer.user', 'spk'])->findOrFail($id);

        if (! $service->spk) {
            abort(404, 'SPK belum di-generate untuk layanan ini.');
        }

        $cachePath = $this->cachePath($service->id);

        if ($this->shouldRegenerate($service, $cachePath)) {
            Cache::lock("pdf-spk-{$service->id}", 120)->block(90, function () use ($service, $cachePath): void {
                if ($this->shouldRegenerate($service, $cachePath)) {
                    $this->storePdf($service, $cachePath);
                }
            });
        }

        $fileName = 'SPK-NOC-'.Str::slug($service->customer->company_name ?: 'pelanggan').'.pdf';

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
            $service->spk->updated_at?->timestamp ?? 0,
        );

        return Storage::disk('local')->lastModified($cachePath) < $lastChangedAt;
    }

    private function storePdf(CustomerService $service, string $cachePath): void
    {
        $pdf = Pdf::loadView('pdf.spk', [
            'service' => $service,
            'customer' => $service->customer,
            'spk' => $service->spk,
        ])->setPaper('a4', 'portrait');

        Storage::disk('local')->put($cachePath, $pdf->output());
    }

    private function cachePath(int $serviceId): string
    {
        return "generated/spk/spk-{$serviceId}.pdf";
    }
}
