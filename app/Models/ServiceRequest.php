<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'request_number',
        'request_type',
        'old_bandwidth',
        'new_bandwidth',
        'new_monthly_fee', 
        'metro_vendor',     
        'deadline_date',
        'stop_date',
        'reason',
        'status',
        'unsigned_pdf_path',
        'signed_pdf_path', 
        'spk_pdf_path',
    ];

    protected $casts = [
        'stop_date' => 'date',
        'deadline_date' => 'date', 
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function bau(): HasOne
    {
        return $this->hasOne(Bau::class);
    }
}