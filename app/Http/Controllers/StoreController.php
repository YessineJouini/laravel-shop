<?php
namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function index()
    {     {
        $products = Product::with('category')->get();
        
        // Always use the store layout (no sidebar)
        return view('store.index', compact('products'));
    }
} 
}