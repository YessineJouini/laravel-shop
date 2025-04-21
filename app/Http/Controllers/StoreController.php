<?php
namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
   {
            public function index()
                    {     
                $products = Product::with('category')->get();

                // Pick layout: admin → views/layout.blade.php, customer → views/store/layout.blade.php
                $layout = (Auth::check() && Auth::user()->role === 'admin')
                    ? 'layout'
                    : 'store.layout';

                return view('store.index', compact('products', 'layout'));
            }
} 
