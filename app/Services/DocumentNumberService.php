<?php

namespace App\Services;

use App\Models\Spk;
use App\Models\Customer;
use App\Models\Baa;
use App\Models\InvoiceRegistrasi;

class DocumentNumberService
{
    private static function getRomanMonth($month)
    {
        $romawis = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $romawis[(int)$month];
    }

    public static function generateSpkNumber()
    {
        $year = date('Y');
        $month = date('n');
        $bulanRomawi = self::getRomanMonth($month);

        $lastData = Spk::whereYear('created_at', $year)->latest('id')->first();
        $urutan = 1;

        if ($lastData && $lastData->spk_number) {
            $parts = explode('/', $lastData->spk_number);
            if (isset($parts[0]) && is_numeric($parts[0])) {
                $urutan = intval($parts[0]) + 1;
            }
        }

        return str_pad($urutan, 3, '0', STR_PAD_LEFT) . '/SPK/MSS/' . $bulanRomawi . '/' . $year;
    }

    public static function generateInvoiceNumber()
    {
        $year = date('Y');
        $month = date('n'); 
        $lastData = InvoiceRegistrasi::whereNotNull('invoice_number')
            ->whereYear('invoice_generated_at', $year)
            ->latest('invoice_generated_at')
            ->first();

        $urutan = 1;

        if ($lastData && $lastData->invoice_number) {
            $parts = explode('/', $lastData->invoice_number);
            if (isset($parts[0]) && is_numeric($parts[0])) {
                $urutan = intval($parts[0]) + 1;
            }
        }

        return str_pad($urutan, 3, '0', STR_PAD_LEFT) . '/INV-MSS/' . $month . '/' . $year;
    }

    public static function generateBaaNumber()
    {
        $year = date('Y');
        $month = date('n');
        $bulanRomawi = self::getRomanMonth($month);

        $lastData = Baa::whereYear('created_at', $year)->latest('id')->first();
        $urutan = 1;

        if ($lastData && $lastData->baa_number) {
            $parts = explode('/', $lastData->baa_number);
            if (isset($parts[0]) && is_numeric($parts[0])) {
                $urutan = intval($parts[0]) + 1;
            }
        }

        return str_pad($urutan, 3, '0', STR_PAD_LEFT) . '/BAA-MSS/' . $bulanRomawi . '/' . $year;
    }
}