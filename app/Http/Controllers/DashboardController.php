<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Address;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch orders for this user (admins see all)
        $orders = Order::with(['orderItems.product', 'shippingAddress'])
            ->when($user->role === 'customer', fn($q) => $q->where('user_id', $user->id))
            ->latest()
            ->get();

        // Fetch all shipping addresses for this user
        $addresses = $user->addresses()
            ->where('type', 'shipping')
            ->latest()
            ->get();
            $layout = (Auth::check() && Auth::user()->role === 'admin')
            ? 'layout'
            : 'layouts.app';
           
        return view('dashboard.index', compact('user','orders','addresses','layout'));
    }

    /**
     * Update or create a shipping address
     */
    public function saveAddress(Request $request, Address $address = null)
    {
        $data = $request->validate([
            'line1'   => 'required|string|max:255',
            'line2'   => 'nullable|string|max:255',
            'city'    => 'required|string|max:100',
            'zip'     => 'required|string|max:50',
            'country' => 'required|string|max:100',
        ]);

        // If an $address was injected, update it; otherwise create a new one
        $address = Address::updateOrCreate(
            ['id' => $address?->id],
            array_merge($data, [
                'user_id' => $request->user()->id,
                'type'    => 'shipping',
            ])
        );

        return back()->with('success', 'Shipping address saved.');
    }

    /**
     * Delete a saved address
     */
    public function deleteAddress(Address $address)
    {
        $this->authorize('delete', $address);
        $address->delete();

        return back()->with('success', 'Address removed.');
    }
    public function showOrder(Order $order)
    {
        // Prevent users from viewing others' orders
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Load items and shipping address
        $order->load('orderItems.product', 'shippingAddress');

        return view('dashboard.order_show', compact('order'));
    }
    public function cancelOrder(Order $order)
    {
        // Prevent users from cancelling others' orders
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the order can be cancelled
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        // Cancel the order
        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order cancelled successfully.');
    }
}
