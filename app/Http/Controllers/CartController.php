<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\OrderPlaced;
use App\Notifications\NewOrderNotification;

class CartController extends Controller
{
    // Add product to the cart
   public function addToCart(Request $request, $productId)
{
    $product = Product::findOrFail($productId);
    
   
    if (Auth::check()) {
        $user = Auth::user();
        $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            $cart->cartItems()->create([
                'product_id' => $productId,
                'quantity' => $request->quantity ?? 1,
                'user_id' => Auth::id(),
            ]);
        }

        $cartCount = auth()->user()->cart?->items->sum('quantity') ?? 0;
    } 
 
    else {
        $cart = session()->get('guest_cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $request->quantity ?? 1;
        } else {
            $cart[$productId] = [
                'product_id' => $productId,
                'quantity' => $request->quantity ?? 1,
            ];
        }
        
        session()->put('guest_cart', $cart);
        $cartCount = array_sum(array_column($cart, 'quantity'));
    }


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
    if (Auth::check()) {
        // Existing logic for authenticated users
        $user = Auth::user();
        $cart = $user->cart;
        $cartItems = $cart ? $cart->items : collect();
    } else {
        // Enhanced logic for guest users
        $guestCart = session()->get('guest_cart', []);
        $cartItems = collect();
        
        if (!empty($guestCart)) {
            $products = Product::with('sale')->findMany(array_keys($guestCart));
            
            foreach ($products as $product) {
                $cartItems->push((object)[
                    'id' => $product->id, // This is the critical missing field
                    'product_id' => $product->id,
                    'quantity' => $guestCart[$product->id]['quantity'],
                    'product' => $product,
                    // Add any other fields your view expects
                ]);
            }
        }
    }

    return view('cart.view', compact('cartItems'));
}

    // Show checkout form 
    public function showCheckoutForm()
{
    // Redirect guests to login page
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please login to proceed to checkout.');
    }

    $user = Auth::user();
    $cart = $user->cart;

    // Handle empty cart case
    if (!$cart || $cart->items->isEmpty()) {
        return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
    }

    // Check stock availability
    foreach ($cart->items as $item) {
        $product = $item->product;
        if ($product->stock < $item->quantity) {
            return redirect()->route('cart.view')->with('error', 'Sorry, not enough stock for "' . $product->name . '".');
        }
    }

    // Load cart items with products
    $cartItems = $cart->items()->with('product')->get();
    $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);
    $addresses = $user->addresses;

    return view('cart.checkout', compact('cartItems', 'total', 'addresses'));
}

    // Finalize checkou
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
    
        if ($request->input('payment_method') === 'card') {
            $rules['card_number']      = 'required|digits:16';
            $rules['card_expiry_date'] = 'required|date_format:m/y';
            $rules['card_cvc']         = 'required|digits:3';
        }
    
        if (! $request->filled('saved_address_id')) {
            $rules['line1']   = 'required|string|max:255';
            $rules['line2']   = 'nullable|string|max:255';
            $rules['city']    = 'required|string|max:255';
            $rules['zip']     = 'required|string|max:255';
            $rules['country'] = 'required|string|max:255';
        }
    
        // Validate
        $validated = $request->validate($rules);

        // STOCK CHECK: Ensure all products in cart have enough stock
       

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
            $admins = User::where('role', 'admin')->get();
foreach ($admins as $admin) {
    $admin->notify(new NewOrderNotification($order));
}
    
            \App\Models\Payment::create([
                'order_id'      => $order->id,
                'method'        => $validated['payment_method'],
                'status'        => $validated['payment_method']==='card' ? 'paid' : 'pending',
                'transaction_id'=> null,
                'amount'        => $order->total,
            ]);
    
            // 4) Copy cart items and reduce stock
            foreach ($cart->items as $item) {
                $order->orderItems()->create([
                    'product_id'=> $item->product_id,
                    'quantity'  => $item->quantity,
                    'price'     => $item->product->sale && $item->product->sale->isActive() 
                    ? $item->product->discounted_price 
                    : $item->product->price,
                ]);
                // Reduce product stock
                $item->product->decrement('stock', $item->quantity);
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

