<?php

namespace App\Services;

use App\Models\Customer;

class InvoiceNumberService
{
    public static function generate(Customer $customer)
    {
        $lastInvoiceNumber = $customer->invoice_number;
        $lastSequence = 0;

        if (! empty($lastInvoiceNumber)) {
            $parts = explode('/', $lastInvoiceNumber);
            $firstPart = $parts[0] ?? '';
            $lastSequence = is_numeric($firstPart) && (int) $firstPart >= 0 ? (int) $firstPart : 0;
        }

        $invoiceCount = $lastSequence + 1;
        $urutan = str_pad($invoiceCount, 3, '0', STR_PAD_LEFT);
        $customerNumber = $customer->customer_number ?? 'C000';
        $template = 'INV-MSS';

        $month = date('n'); // Format angka 1-12 (tanpa 0 di depan)
        $year = date('Y');  // Format 4 digit tahun

        // 5. Rangkai menjadi satu kesatuan
        $invoiceNumber = "{$urutan}/{$customerNumber}/{$template}/{$month}/{$year}";

        return $invoiceNumber;
    }
}