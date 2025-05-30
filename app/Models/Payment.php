<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'method',
        'status',
        'transaction_id',
        'amount',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
