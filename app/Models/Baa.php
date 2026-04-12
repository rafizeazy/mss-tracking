<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baa extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'devices' => 'array',
        'activation_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function spk()
    {
        return $this->belongsTo(Spk::class);
    }
}