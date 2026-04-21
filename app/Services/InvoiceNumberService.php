<?php

namespace App\Services;

use App\Models\Customer;

class InvoiceNumberService
{
    public static function generate(Customer $customer)
    {
        $invoiceCount = $customer->invoices()->count() + 1;
        $urutan = str_pad($invoiceCount, 3, '0', STR_PAD_LEFT); 
        $customerNumber = $customer->customer_number ?? 'C000';
        $template = 'INV-MSS';

        $month = date('n');
        $year = date('Y');
        $invoiceNumber = "{$urutan}/{$customerNumber}/{$template}/{$month}/{$year}";

        return $invoiceNumber;
    }
}