<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = ['id'];

    // Relasi balik ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
