<?php

namespace App\Services;

use App\Models\ServiceRequest;
use Carbon\Carbon;

class PerubahanLayananNumberService
{

    public static function generate(ServiceRequest $serviceRequest): string
    {
        $data = self::prepareData($serviceRequest);
        
        return "Form-{$data['sequence']}/PL/MSS/{$data['romanMonth']}/{$data['year']}";
    }

    public static function generateSpk(ServiceRequest $serviceRequest): string
    {
        $data = self::prepareData($serviceRequest);
        
        return "SPK-{$data['sequence']}/PL/MSS/{$data['romanMonth']}/{$data['year']}";
    }

    private static function prepareData(ServiceRequest $serviceRequest): array
    {
        $date = $serviceRequest->created_at ? Carbon::parse($serviceRequest->created_at) : Carbon::now();
        $year = $date->format('Y');
        $month = $date->format('n');

        $romans = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];

        if ($serviceRequest->id) {
            $sequence = ServiceRequest::whereYear('created_at', $year)
                           ->where('id', '<=', $serviceRequest->id)
                           ->count();
        } else {
            $sequence = ServiceRequest::whereYear('created_at', $year)->count() + 1;
        }

        return [
            'sequence' => $sequence,
            'romanMonth' => $romans[$month],
            'year' => $year
        ];
    }
}