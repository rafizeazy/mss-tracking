<?php

namespace App\Enums;

enum Role: string
{
    case SuperAdmin = 'super_admin';
    case Noc = 'noc';
    case Finance = 'finance';
    case Marketing = 'marketing';
    case Customer = 'customer';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::Noc => 'NOC',
            self::Finance => 'Finance',
            self::Marketing => 'Marketing',
            self::Customer => 'Pelanggan',
        };
    }
}