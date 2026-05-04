<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\CustomerService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BaaController extends Controller
{
    public function streamBaa(int $id): BinaryFileResponse
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

        $cachePath = $this->cachePath($service->id);

        if ($this->shouldRegenerate($service, $cachePath)) {
            Cache::lock("pdf-baa-{$service->id}", 120)->block(90, function () use ($service, $cachePath): void {
                if ($this->shouldRegenerate($service, $cachePath)) {
                    $this->storePdf($service, $cachePath);
                }
            });
        }

        $filename = 'BAA-'
            .Str::slug($service->customer->company_name ?: 'pelanggan')
            .'-'
            .Str::slug($service->baa->baa_number ?: 'draft')
            .'.pdf';

        return response()->file(Storage::disk('local')->path($cachePath), [
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
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
            $service->spk?->updated_at?->timestamp ?? 0,
            $service->baa->updated_at?->timestamp ?? 0,
        );

        return Storage::disk('local')->lastModified($cachePath) < $lastChangedAt;
    }

    private function storePdf(CustomerService $service, string $cachePath): void
    {
        $pdf = Pdf::loadView('pdf.baa', [
            'customer' => $service->customer,
            'service' => $service,
            'baa' => $service->baa,
            'spk' => $service->spk,
        ])->setPaper('a4', 'portrait');

        Storage::disk('local')->put($cachePath, $pdf->output());
    }

    private function cachePath(int $serviceId): string
    {
        return "generated/baa/baa-{$serviceId}.pdf";
    }
}
