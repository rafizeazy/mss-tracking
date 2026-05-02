<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Baa extends Model
{
    use HasFactory;

    protected $table = 'baa';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'devices' => 'array',
            'activation_date' => 'date',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(CustomerService::class, 'service_id');
    }

    public function spk(): BelongsTo
    {
        return $this->belongsTo(Spk::class, 'spk_id');
    }
}