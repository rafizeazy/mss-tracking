<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): HasOne
    {
        return $this->hasOne(CustomerService::class)->latestOfMany();
    }

    public function services(): HasMany
    {
        return $this->hasMany(CustomerService::class);
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

    public function spks(): HasManyThrough
    {
        return $this->hasManyThrough(
            Spk::class,
            CustomerService::class,
            'customer_id',
            'service_id',
            'id',
            'id'
        );
    }

    public function baas(): HasManyThrough
    {
        return $this->hasManyThrough(
            Baa::class,
            CustomerService::class,
            'customer_id',
            'service_id',
            'id',
            'id'
        );
    }

    public function invoiceRegistrasis(): HasManyThrough
    {
        return $this->hasManyThrough(
            InvoiceRegistrasi::class,
            CustomerService::class,
            'customer_id',
            'service_id',
            'id',
            'id'
        );
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }
}
