<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\WishlistItems; 
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = WishlistItems::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function add($productId)
    {
        $user = Auth::user();

        $exists = WishlistItems::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        if (!$exists) {
            WishlistItems::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to wishlist!');
    }

    public function remove($productId)
    {
        WishlistItems::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();

        return redirect()->back()->with('success', 'Product removed from wishlist.');
    }
    
}
