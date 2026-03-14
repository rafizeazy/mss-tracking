<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'invoice_generated_at' => 'datetime',
        ];
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function spk()
    {
        return $this->hasOne(Spk::class);
    }
    public function baa()
    {
        return $this->hasOne(Baa::class);
    }
}
