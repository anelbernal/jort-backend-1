<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'title', 'short_desc', 'long_desc', 'category', 'current_bid', 'increment'];

    public function seller()
    {
        return $this->belongsTo(User::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function medias()
    {
        return $this->hasMany(Media::class);
    }

    public function payment_intents()
    {
        return $this->hasMany(PaymentIntent::class);
    }

    public function winners()
    {
        return $this->hasMany(Winner::class);
    }
}
