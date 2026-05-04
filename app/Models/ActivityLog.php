<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'properties' => 'array',
        ];
    }

    public static function record(string $action, string $description, ?Customer $customer = null, ?string $reason = null, array $properties = []): self
    {
        return self::create([
            'user_id' => auth()->id(),
            'customer_id' => $customer?->id,
            'action' => $action,
            'description' => $description,
            'reason' => $reason,
            'properties' => $properties ?: null,
            'ip_address' => request()?->ip(),
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }
}
