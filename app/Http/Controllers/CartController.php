<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Add product to the cart
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $user = Auth::user();
        $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            $cart->cartItems()->create([
                'product_id' => $productId,
                'quantity' => 1,
                'user_id' => Auth::id(),
            ]);
        }

        return redirect()->route('store.index')->with('success', 'Item added to cart!');
    }

    // View the cart items
    public function view()
    {
        $user = Auth::user();
        $cart = $user->cart;
        $cartItems = $cart ? $cart->items : collect();
        return view('cart.view', compact('cartItems'));
    }

    // Show checkout form (shipping details + payment options)
    public function showCheckoutForm()
    {
        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        $cartItems = $cart->items()->with('product')->get();
        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

        return view('cart.checkout', compact('cartItems', 'total'));
    }

    // Finalize checkout: Create order, save address, and process payment
    public function checkout(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user
        $cart = $user->cart;
    
        // Validate the cart exists and is not empty
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }
    
        // Validate the incoming address data (ensure they provide the required details)
        $validated = $request->validate([
            'line1' => 'required|string|max:255',
            'line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);
    
        $order = null;  // Initialize the $order variable outside the transaction
    
        // Start a transaction to ensure everything happens atomically
        DB::transaction(function () use ($user, $cart, $validated, &$order, $request) {
            // Create or update the shipping address
            $address = Address::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'type' => 'shipping',
                ],
                [
                    'line1' => $validated['line1'],
                    'line2' => $validated['line2'],
                    'city' => $validated['city'],
                    'zip' => $validated['zip'],
                    'country' => $validated['country'],
                ]
            );
    
            // Create the order
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $cart->items->sum(fn($item) => $item->quantity * $item->product->price),
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'shipping_address_id' => $address->id,
            ]);
    
            // Copy cart items to the order
            foreach ($cart->items as $item) {
                $order->orderItems()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }
    
            // Clear the cart items after the order is placed
            $cart->items()->delete();
        });
    
        // Redirect to the order confirmation page with the order ID
        return redirect()->route('cart.confirmation', ['order' => $order->id])
                         ->with('success', 'Your order has been placed!');
    }
    public function showConfirmation(Order $order)
{
    $shippingAddress = $order->shippingAddress;

    return view('cart.confirmation', [
        'order' => $order,
        'shippingAddress' => $shippingAddress,
    ]);
}
    
}

