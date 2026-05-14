<?php

namespace App\Services;

use App\Models\Baa;
use App\Models\InvoiceRegistrasi;
use App\Models\Spk;

class DocumentNumberService
{
    private static function getRomanMonth(int $month): string
    {
        $romawis = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];

        return $romawis[$month];
    }

    public static function generateSpkNumber(): string
    {
        $year = date('Y');
        $month = (int) date('n');
        $bulanRomawi = self::getRomanMonth($month);
        $sequence = self::nextSequence(
            Spk::query()
                ->whereNotNull('spk_number')
                ->where('spk_number', 'like', '%/'.$year)
                ->pluck('spk_number')
                ->all()
        );

        return str_pad((string) $sequence, 3, '0', STR_PAD_LEFT).'/SPK/MSS/'.$bulanRomawi.'/'.$year;
    }

    public static function generateInvoiceNumber(): string
    {
        $year = date('Y');
        $month = date('n');
        $sequence = self::nextSequence(
            InvoiceRegistrasi::query()
                ->whereNotNull('invoice_number')
                ->where('invoice_number', 'like', '%/'.$year)
                ->pluck('invoice_number')
                ->all()
        );

        return str_pad((string) $sequence, 3, '0', STR_PAD_LEFT).'/INV-MSS/'.$month.'/'.$year;
    }

    public static function generateBaaNumber(): string
    {
        $year = date('Y');
        $month = (int) date('n');
        $bulanRomawi = self::getRomanMonth($month);
        $sequence = self::nextSequence(
            Baa::query()
                ->whereNotNull('baa_number')
                ->where('baa_number', 'like', '%/'.$year)
                ->pluck('baa_number')
                ->all()
        );

        return str_pad((string) $sequence, 3, '0', STR_PAD_LEFT).'/BAA-MSS/'.$bulanRomawi.'/'.$year;
    }

    /**
     * @param  array<int, string|null>  $documentNumbers
     */
    private static function nextSequence(array $documentNumbers): int
    {
        $lastSequence = collect($documentNumbers)
            ->map(function (?string $documentNumber): int {
                $sequence = explode('/', (string) $documentNumber)[0] ?? null;

                return is_numeric($sequence) ? (int) $sequence : 0;
            })
            ->max();

        return ((int) $lastSequence) + 1;
    }
}
