<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    protected $guarded = ['id'];

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

    // Relasike tabel customer_services
    public function service(): HasOne
    {
        return $this->hasOne(CustomerService::class);
    }

    // Relasi ke tabel invoice_registrasi
    public function invoiceRegistrasi(): HasOne
    {
        return $this->hasOne(InvoiceRegistrasi::class);
    }
}