<?php

namespace App\Services;

use App\Models\Bau;
use Carbon\Carbon;

class BauNumberService
{
    public static function generate(Bau $bau): string
    {
        $date = $bau->created_at ? Carbon::parse($bau->created_at) : Carbon::now();
        $year = $date->format('Y');
        $month = $date->format('n');

        $romans = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $romanMonth = $romans[$month];

        if ($bau->id) {
            $sequence = Bau::whereYear('created_at', $year)
                           ->where('id', '<=', $bau->id)
                           ->count();
        } else {
            $sequence = Bau::whereYear('created_at', $year)->count() + 1;
        }

        $formattedSequence = str_pad($sequence, 3, '0', STR_PAD_LEFT);

        return "{$formattedSequence}/BAU-MSS/{$romanMonth}/{$year}";
    }
}