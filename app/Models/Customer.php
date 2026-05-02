<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Customer extends Model
{
    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): HasOne
    {
        return $this->hasOne(CustomerService::class);
    }

    public function spk(): HasOneThrough
    {
        return $this->hasOneThrough(
            Spk::class,
            CustomerService::class,
            'customer_id',
            'service_id',
            'id',
            'id'
        );
    }
    
    public function baa(): HasOneThrough
    {
        return $this->hasOneThrough(
            Baa::class,
            CustomerService::class,
            'customer_id',
            'service_id',
            'id',
            'id'
        );
    }

    public function invoiceRegistrasi(): HasOneThrough
    {
        return $this->hasOneThrough(
            InvoiceRegistrasi::class,
            CustomerService::class,
            'customer_id',
            'service_id',
            'id',
            'id'
        );
    }
}