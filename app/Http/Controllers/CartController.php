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
        $addresses = auth()->user()->addresses;
        return view('cart.checkout', compact('cartItems', 'total' , 'addresses'));
    }

    // Finalize checkout: Create order, save address, and process payment
    public function checkout(Request $request)
{
    $user = auth()->user();
    $cart = $user->cart;

    if (! $cart || $cart->items->isEmpty()) {
        return redirect()->route('cart.view')
                         ->with('error', 'Your cart is empty.');
    }

    // 1) Validate inputs: either saved_address_id OR new address fields must be present
    $validated = $request->validate([
        'saved_address_id' => 'nullable|exists:addresses,id',
        'line1'            => 'required_without:saved_address_id|string|max:255',
        'line2'            => 'nullable|string|max:255',
        'city'             => 'required_without:saved_address_id|string|max:255',
        'zip'              => 'required_without:saved_address_id|string|max:255',
        'country'          => 'required_without:saved_address_id|string|max:255',
        'payment_method'   => 'required|in:cash_on_delivery,card',
        // If you want to validate card inputs too:
        'card_number'      => 'required_if:payment_method,card|digits:16',
        'card_expiry_date' => 'required_if:payment_method,card|date_format:m/y',
        'card_cvc'         => 'required_if:payment_method,card|digits:3',
    ]);

    DB::transaction(function () use ($user, $cart, $validated, &$order) {
        // 2) Determine which address to use
        if (!empty($validated['saved_address_id'])) {
            // Use existing address
            $address = Address::findOrFail($validated['saved_address_id']);
        } else {
            // Create or update the shipping address for this user
            $address = Address::updateOrCreate(
                ['user_id' => $user->id, 'type' => 'shipping'],
                [
                    'line1'   => $validated['line1'],
                    'line2'   => $validated['line2'] ?? null,
                    'city'    => $validated['city'],
                    'zip'     => $validated['zip'],
                    'country' => $validated['country'],
                ]
            );
        }

        // 3) Create the order
        $order = Order::create([
            'user_id'             => $user->id,
            'total'               => $cart->items->sum(fn($i) => $i->quantity * $i->product->price),
            'status'              => 'pending',
            'payment_method'      => $validated['payment_method'],
            'shipping_address_id' => $address->id,
        ]);

        // 4) (Optional) record in payments table
        \App\Models\Payment::create([
            'order_id'      => $order->id,
            'method'        => $validated['payment_method'],
            'status'        => $validated['payment_method'] === 'card' ? 'paid' : 'pending',
            'transaction_id'=> null,
            'amount'        => $order->total,
        ]);

        // 5) Copy cart items
        foreach ($cart->items as $item) {
            $order->orderItems()->create([
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);
        }

        // 6) Clear cart
        $cart->items()->delete();
    });

    // 7) Redirect to confirmation
    return redirect()
        ->route('cart.confirmation', ['order' => $order->id])
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
public function updateQuantity(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $user = Auth::user();
        $cart = $user->cart;
        $item = $cart->items()->where('id', $itemId)->firstOrFail();

        $item->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.view')
                         ->with('success', 'Quantity updated!');
    }

    /**
     * Remove a single item from the cart.
     */
    public function removeItem($itemId)
    {
        $user = Auth::user();
        $cart = $user->cart;
        $item = $cart->items()->where('id', $itemId)->firstOrFail();

        $item->delete();

        return redirect()->route('cart.view')
                         ->with('success', 'Item removed from cart.');
    }


    
}

