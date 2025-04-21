<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
{
    Log::info('Authenticated User Class: ' . get_class(Auth::user()));
    $user = Auth::user();

    // Debugging: Log the authenticated user's ID and role
    Log::info('Authenticated User ID: ' . $user->id);
    Log::info('Authenticated User Role: ' . $user->role);

    $orders = collect();

    if ($user) {
        if ($user->role === 'customer') {
            // Fetch orders for customers
            $orders = $user
                ->orders()
                ->with('orderItems.product')
                ->latest()
                ->get();
        } elseif ($user->role === 'admin') {
            // Fetch all orders for admins
            $orders = \App\Models\Order::with('orderItems.product')
                ->latest()
                ->get();
        }
    }

    return view('dashboard.index', compact('user', 'orders'));
}
    }

