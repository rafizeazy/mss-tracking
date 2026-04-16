<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'invoice_generated_at' => 'datetime',
            'monthly_fee' => 'decimal:2',
            'registration_fee' => 'decimal:2',
            'term_of_service' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function spk(): HasOne
    {
        return $this->hasOne(Spk::class);
    }
    
    public function baa(): HasOne
    {
        return $this->hasOne(Baa::class);
    }
}