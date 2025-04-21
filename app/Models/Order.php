<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{

    protected $table = 'orders';

    protected $fillable = [
        'user_id', 'status','total'
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
       
}
