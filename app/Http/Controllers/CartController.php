<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        // Validate the product exists
        $product = Product::findOrFail($productId);

        // Fetch or create the user's cart
        $user = Auth::user();

        // Make sure user has a cart, otherwise create one
        $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);

        // Check if the product is already in the cart
        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            // If the item exists, increase quantity
            $cartItem->increment('quantity');
        } else {
            // Else, create a new cart item
            $cart->cartItems()->create([
                'product_id' => $productId,
                'quantity' => 1,
                'user_id' => Auth::id(), // <-- Add this
            ]);
        }

        // Return a redirect with a success message
        return redirect()->route('store.index')->with('success', 'Item added to cart!');
    }

    public function view()
    {
        $user = Auth::user();
        $cart = $user->cart;

        $cartItems = $cart ? $cart->items : collect(); // fallback if no cart exists

        return view('cart.view', compact('cartItems'));
    }
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart;

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.view')
                             ->with('error', 'Your cart is empty.');
        }

        // Use transaction in case something fails mid-way
        DB::transaction(function () use ($user, $cart) {
            // 1) Create the order
            $order = Order::create([
                'user_id'   => $user->id,
                'total'     => $cart->items->sum(fn($item) => $item->quantity * $item->product->price),
                'status'    => 'pending',
            ]);

            // 2) Copy cart items into order_items
            foreach ($cart->items as $item) {
                $order->orderItems()->create([
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                ]);
            }

            // 3) Clear the cart
            $cart->items()->delete();
        });

        return redirect()->route('store.index')
                         ->with('success', 'Your order has been placed!');
    }
}
