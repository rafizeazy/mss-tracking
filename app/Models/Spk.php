<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Spk extends Model
{
    use HasFactory;

    protected $table = 'spk';

    protected $guarded = ['id'];

    public function service(): BelongsTo
    {
        return $this->belongsTo(CustomerService::class, 'service_id');
    }

    public function baa(): HasOne
    {
        return $this->hasOne(Baa::class, 'spk_id');
    }
}