<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    /**
     * Display a listing of orders with sorting and pagination.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
    
        // Base query with eager loading
        $query = Order::with(['user', 'orderItems.product', 'shippingAddress']);
    
        // Sorting by user name
        if ($sort === 'user') {
            $query->leftJoin('users', 'orders.user_id', '=', 'users.id')  // leftJoin ensures we don't lose orders with no users
                  ->orderBy('users.name', $direction)
                  ->addSelect('orders.*'); // Ensure we keep the full order data
        } else {
            // Apply sorting based on other fields (status, total, created_at)
            $query->orderBy($sort, $direction);
        }

        // Paginate results and preserve sorting parameters
        $orders = $query->paginate(10)->appends(compact('sort', 'direction'));

        // Return the view with the sorted orders
        return view('orders.index', compact('orders', 'sort', 'direction'));
    }

    /**
     * Show the details of a single order.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Load the order with its relationships
        $order = Order::with(['user', 'orderItems.product', 'shippingAddress'])
            ->findOrFail($id); // Will throw a 404 error if not found

        // Return the view with the order details
        return view('orders.show', compact('order'));
    }

    /**
     * Mark an order as accepted (shipping in progress).
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept(Order $order)
    {
        $order->update(['status' => Order::STATUS_SHIPPING_IN_PROGRESS]);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order marked as Shipping In Progress.');
    }

    /**
     * Mark an order as declined.
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function decline(Order $order)
    {
        $order->update(['status' => Order::STATUS_DECLINED]);

        return redirect()
            ->route('orders.show', $order)
            ->with('error', 'Order has been declined.');
    }
}
