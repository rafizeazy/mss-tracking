<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerService extends Model
{
    protected $guarded = ['id']; 
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    protected function casts(): array
    {
        return [
            'monthly_fee' => 'decimal:2',
            'registration_fee' => 'decimal:2',
            'term_of_service' => 'integer',
        ];
    }
}
