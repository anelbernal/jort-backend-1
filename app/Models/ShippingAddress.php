<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = ['street_1', 'street_2', 'city', 'state', 'postal_code', 'is_primary'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
