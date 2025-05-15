<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{

    // In Order model
public const STATUS_SHIPPING_IN_PROGRESS = 'shipping_in_progress';
public const STATUS_DECLINED            = 'declined';

    protected $table = 'orders';
    protected $casts = [
        'total' => 'decimal:2',
    ];


    protected $fillable = [
        'user_id',
        'status',
        'total',
        'payment_method',
        'shipping_address_id',
    ];


    public function items()
            {
                return $this->hasMany(OrderItem::class);
            }
     public function orderItems()
            {
                return $this->hasMany(OrderItem::class);
            }


    public function user()
            {
                return $this->belongsTo(User::class, 'user_id');
            }


    public function getTotalAttribute()
            {
                return $this->items
                            ->sum(fn($item) => $item->quantity * $item->price);
            }
            public function shippingAddress()
            {
                return $this->hasOne(Address::class, 'user_id', 'user_id') // Assuming the address is related to user_id
                           ->where('type', 'shipping');
            }
            public function payment()
{
    return $this->hasOne(\App\Models\Payment::class);
}

}
