<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Rename this to cartItems(), so Cart::cartItems() works
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // (Optional) keep items() as an alias if you like:
    public function items()
    {
        return $this->cartItems();
    }
}
