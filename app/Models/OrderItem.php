<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price'
    ];

    // Each OrderItem belongs to one Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Each OrderItem refers to one Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
