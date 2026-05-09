<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerService extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function spk(): HasOne
    {
        return $this->hasOne(Spk::class, 'service_id');
    }

    public function baa(): HasOne
    {
        return $this->hasOne(Baa::class, 'service_id');
    }

    public function invoiceRegistrasi(): HasOne
    {
        return $this->hasOne(InvoiceRegistrasi::class, 'service_id');
    }

    public function moveToStatus(string $status, ?string $reason = null): bool
    {
        $statusData = [
            'status' => $status,
            'status_reason' => $reason,
            'status_reason_at' => $reason ? now() : null,
        ];

        $updated = $this->update($statusData);

        $this->customer?->update($statusData);

        return $updated;
    }

    protected function casts(): array
    {
        return [
            'monthly_fee' => 'decimal:2',
            'registration_fee' => 'decimal:2',
            'term_of_service' => 'integer',
            'status_reason_at' => 'datetime',
        ];
    }
}
