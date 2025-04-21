<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $user = User::find(6);

        if ($user) {
            $order = Order::create([
                'user_id' => $user->id,
                'total' => 100.00,
                'status' => 'pending',
            ]);

            $order->orderItems()->create([
                'product_id' => 1, // Make sure product ID 1 exists
                'quantity' => 2,
                'price' => 50.00,
            ]);
        }
    }
}
