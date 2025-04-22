<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Grab requested sort field & direction, with sensible defaults
    $sort      = $request->get('sort', 'created_at');
    $direction = $request->get('direction', 'desc');

    // Base query
    $query = Order::with(['user', 'orderItems.product', 'shippingAddress']);

    // Apply sorting
    switch ($sort) {
        case 'total':
            $query->orderBy('total', $direction);
            break;

        case 'user':
            // join to sort by user name
            $query->join('users', 'orders.user_id', '=', 'users.id')
                  ->orderBy('users.name', $direction)
                  ->select('orders.*');
            break;

        case 'status':
            $query->orderBy('status', $direction);
            break;

        default:
            // created_at or any other fallback
            $query->orderBy($sort, $direction);
    }

    // Paginate and preserve sort params
    $orders = $query->paginate(10)
                    ->appends(compact('sort','direction'));

    return view('orders.index', compact('orders','sort','direction'));
        $orders = Order::with(['user', 'orderItems.product', 'shippingAddress'])
            ->latest()
            ->paginate(10); // Paginate for cleaner admin view

        return view('orders.index', compact('orders'));
    }
    public function show($id)
{
    $order = Order::with(['user', 'orderItems.product', 'shippingAddress'])->findOrFail($id);

    return view('orders.show', compact('order'));
}
public function accept(Order $order)
{
    $order->update(['status' => Order::STATUS_SHIPPING_IN_PROGRESS]);

    return redirect()
        ->route('orders.show', $order)
        ->with('success', 'Order marked as Shipping In Progress.');
}

/**
 * Mark an order as declined.
 */
public function decline(Order $order)
{
    $order->update(['status' => Order::STATUS_DECLINED]);

    return redirect()
        ->route('orders.show', $order)
        ->with('error', 'Order has been declined.');
}
}
