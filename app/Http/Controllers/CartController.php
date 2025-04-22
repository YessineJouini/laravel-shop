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

    public function showCheckoutForm()
    {
        $user = Auth::user();
        $cart = $user->cart;

        // Check if the user has items in the cart
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.view')
                             ->with('error', 'Your cart is empty.');
        }

        // Fetch cart items and calculate total
        $cartItems = $cart->items()->with('product')->get();
        $total = $cartItems->sum(fn($i) => $i->quantity * $i->product->price);

        // Fetch the user's shipping address (if any)
        $shippingAddress = $user->addresses()->where('type', 'shipping')->first();

        // Return the view with necessary data
        return view('cart.checkout', compact('cartItems', 'total', 'shippingAddress'));
    }

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

        // If payment is card, simulate card processing
        if ($request->payment_method === 'card') {
            if (!$this->mockPayment($request->card_number)) {
                return redirect()->route('cart.view')
                                 ->with('error', 'Invalid card number. Please use a valid test card.');
            }
        }

        // Redirect to the order confirmation page with the order ID
        return redirect()->route('order.confirmation', ['order' => $order->id])
                         ->with('success', 'Your order has been placed!');
    }

    // Simulated payment method
    protected function mockPayment($cardNumber)
    {
        // Only accept a valid mock card number (can replace with more complex logic)
        return preg_replace('/\D/', '', $cardNumber) === '4111111111111111'; // Visa test number
    }

    public function showConfirmation($orderId)
    {
        // Get the order with its order items and shipping address (if exists)
        $order = Order::with('orderItems.product', 'shippingAddress')->findOrFail($orderId);

        // Check if shippingAddress exists, if not set it to an empty array
        $shippingAddress = $order->shippingAddress ?? null;

        return view('cart.confirmation', compact('order', 'shippingAddress'));
    }
}
