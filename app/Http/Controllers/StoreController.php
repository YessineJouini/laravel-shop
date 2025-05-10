<?php
namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class StoreController extends Controller
   {
    public function index(Request $request)
    {
        $query = Product::with('category');

        // search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                }
            }

        // Paginate
        $products = $query->latest()->paginate(12);

        // Load all categories
        $categories = Category::all();

        // Pick layout
        $isAdminStore = (Auth::check() && Auth::user()->role === 'admin');
        $layout = $isAdminStore ? 'layout' : 'layouts.app';

        return view('store.index', compact('products', 'categories', 'layout', 'isAdminStore'));
    }
}
