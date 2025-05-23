<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of products with search & sorting.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Search by name (case insensitive)
        if ($search = $request->input('search')) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        // Validate sort inputs for security & prevent injection
        $allowedSorts = ['name', 'price', 'stock', 'created_at'];
        $sortBy = in_array($request->input('sort_by'), $allowedSorts) ? $request->input('sort_by') : 'name';

        $sortDirection = $request->input('sort_direction') === 'desc' ? 'desc' : 'asc';

        $products = $query->orderBy($sortBy, $sortDirection)->paginate(15)->withQueryString();

        // Pass current filters & sorting so UI can maintain state
        return view('products.index', compact('products', 'sortBy', 'sortDirection', 'search'));
    }

   
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // Validate inputs strictly
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Handle image upload safely
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('productImg', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    
    public function show(Product $product)
    {
        $product->load('reviews.user');  
        return view('products.show', compact('product'));
    }

 
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

 
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // If new image uploaded, delete old one to save storage, then store new
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('productImg', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Delete product image if exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    public function addToCart(Request $request, $productId)
    {
        // ...existing add to cart logic...

        if ($request->ajax()) {
            return response()->json(['message' => 'Product added to cart!']);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }
}
