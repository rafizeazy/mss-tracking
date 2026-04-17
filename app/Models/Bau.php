<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bau extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_request_id',
        'upgrade_date',
        'noc_pic_name',
        'noc_signature_path',
        'speedtest_image_path',
        'unsigned_bau_path',
        'signed_bau_path',
    ];

    protected $casts = [
        'upgrade_date' => 'date',
    ];

    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }
}