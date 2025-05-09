<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // (Optional) keep items() as an alias if you like:
    public function items()
    {
        return $this->cartItems();
    }
    public function view()
{
    $user = Auth::user();
    $cart = $user->cart;

    $cartItems = $cart ? $cart->items : collect(); // fallback if no cart exists

    return view('cart.view', compact('cartItems'));
}

}
