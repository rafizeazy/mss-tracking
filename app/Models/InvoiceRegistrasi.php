<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceRegistrasi extends Model
{
    protected $table = 'invoice_registrasi'; 
    
    protected $guarded = ['id'];

    public function service(): BelongsTo
    {
        return $this->belongsTo(CustomerService::class, 'service_id');
    }

    protected function casts(): array
    {
        return [
            'invoice_generated_at' => 'datetime',
        ];
    }
}