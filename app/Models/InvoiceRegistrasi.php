<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceRegistrasi extends Model
{
    protected $table = 'invoice_registrasi'; 
    protected $guarded = ['id'];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    protected function casts(): array
    {
        return [
            'invoice_generated_at' => 'datetime',
        ];
    }
}