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
use App\Notifications\OrderPlaced;

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

        // Calculate new cart count (assuming user is authenticated)
        $cartCount = auth()->user()->cart?->items->sum('quantity') ?? 0;

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Product added to cart!',
                'cart_count' => $cartCount
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
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
            return redirect()
                ->route('cart.view')
                ->with('error', 'Your cart is empty.');
        }
    
        // Base rules
        $rules = [
            'saved_address_id' => 'nullable|exists:addresses,id',
            'payment_method'   => 'required|in:cash_on_delivery,card',
        ];
    
        // If user picked Card, require valid card fields
        if ($request->input('payment_method') === 'card') {
            $rules['card_number']      = 'required|digits:16';
            $rules['card_expiry_date'] = 'required|date_format:m/y';
            $rules['card_cvc']         = 'required|digits:3';
        }
    
        // If no saved address is chosen, require a new one
        if (! $request->filled('saved_address_id')) {
            $rules['line1']   = 'required|string|max:255';
            $rules['line2']   = 'nullable|string|max:255';
            $rules['city']    = 'required|string|max:255';
            $rules['zip']     = 'required|string|max:255';
            $rules['country'] = 'required|string|max:255';
        }
    
        // Validate
        $validated = $request->validate($rules);
    
        // Wrap in transaction
        DB::transaction(function () use ($user, $cart, $validated, &$order) 
        {
    
            // 1) Pick or create address
            if (! empty($validated['saved_address_id'])) {
                $address = Address::findOrFail($validated['saved_address_id']);
            } else {
                $address = Address::updateOrCreate(
                    ['user_id'=> $user->id, 'type'=>'shipping'],
                    [
                      'line1'   => $validated['line1'],
                      'line2'   => $validated['line2'] ?? null,
                      'city'    => $validated['city'],
                      'zip'     => $validated['zip'],
                      'country' => $validated['country'],
                    ]
                );
            }
    
            // 2) Create order
            $order = Order::create([
                'user_id'             => $user->id,
                'total'               => $cart->items->sum(fn($i)=> $i->quantity*($i->product->sale && $i->product->sale->isActive() 
                ? $i->product->discounted_price 
                : $i->product->price)),
                'status'              => 'pending',
                'payment_method'      => $validated['payment_method'],
                'shipping_address_id' => $address->id,
            ]);
    
            // 3) Optional: record payment
            \App\Models\Payment::create([
                'order_id'      => $order->id,
                'method'        => $validated['payment_method'],
                'status'        => $validated['payment_method']==='card' ? 'paid' : 'pending',
                'transaction_id'=> null,
                'amount'        => $order->total,
            ]);
    
            // 4) Copy cart items
            foreach ($cart->items as $item) {
                $order->orderItems()->create([
                    'product_id'=> $item->product_id,
                    'quantity'  => $item->quantity,
                    'price'     => $item->product->sale && $item->product->sale->isActive() 
                    ? $item->product->discounted_price 
                    : $item->product->price,
                ]);
            }
        
            // 5) Clear cart
            $cart->items()->delete();
        });
        $order->load('orderItems.product', 'shippingAddress');
        $user->notify(new OrderPlaced($order));
    
        // Redirect to confirmation
        return redirect()
            ->route('cart.confirmation', ['order'=>$order->id])
            ->with('success','Your order has been placed!');
    }
    public function showConfirmation(Order $order)
{
    // Eager‐load items and address
    $order->load('orderItems.product', 'shippingAddress');

    return view('cart.confirmation', [
        'order'           => $order,
        'shippingAddress' => $order->shippingAddress,
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

    $cartCount = $cart->items->sum('quantity');
    $cartTotal = $cart->items->sum(function($i) {
        return $i->quantity * ($i->product->sale && $i->product->sale->isActive() ? $i->product->discounted_price : $i->product->price);
    });

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'cart_total' => number_format($cartTotal, 2),
            'item_subtotal' => number_format(
                $item->quantity * ($item->product->sale && $item->product->sale->isActive() ? $item->product->discounted_price : $item->product->price),
                2
            )
        ]);
    }

    return redirect()->route('cart.view')
                     ->with('success', 'Quantity updated!');
}

public function removeItem(Request $request, $itemId)
{
    $user = Auth::user();
    $cart = $user->cart;
    $item = $cart->items()->where('id', $itemId)->firstOrFail();
    $item->delete();

    $cartCount = $cart->items->sum('quantity');
    $cartTotal = $cart->items->sum(function($i) {
        return $i->quantity * ($i->product->sale && $i->product->sale->isActive() ? $i->product->discounted_price : $i->product->price);
    });

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'cart_total' => number_format($cartTotal, 2),
            'item_id' => $itemId
        ]);
    }

    return redirect()->route('cart.view')
                     ->with('success', 'Item removed from cart.');
}

    public function add(Request $request, Product $product)
    {
        try {
            $quantity = $request->input('quantity', 1);
            
            // Get or create cart for authenticated user
            $cart = auth()->user()->cart ?? auth()->user()->cart()->create();
            
            // Add or update item in cart
            $cart->items()->updateOrCreate(
                ['product_id' => $product->id],
                ['quantity' => $quantity]
            );

            // Get updated cart count
            $cartCount = $cart->items->sum('quantity');

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully',
                'cartCount' => $cartCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart'
            ], 500);
        }
    }
}

