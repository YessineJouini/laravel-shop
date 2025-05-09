<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('products.create', compact('categories')); // Pass categories to the view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'=> 'nullable|image|mimes:jpg,png,jpeg|max:2028',
        ]);
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('productImg', 'public');
        }
    

        // Create the product
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' =>$request->category_id,
            'image' => $imagePath,
        ]);

        // success message
        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
  public function show(Product $product)
{
    $product->load(['reviews.user']); 
    return view('products.show', compact('product'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    { 
        // Retrieve the product by its ID or fail with a 404 error if not found
        $product = Product::findOrFail($id);
    
        // Retrieve all categories for the dropdown
        $categories = Category::all();
    
        // Pass both the product and categories to the view
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    { 
    // Validate the request data (include all necessary fields and rules)
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string', // Added missing description validation
        'price' => 'required|numeric|min:0', // Added min:0 to match store validation
        'stock' => 'required|integer|min:0', // Added min:0 to match store validation
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpg,png,jpeg', // Added image validation
    ]);

    $product = Product::findOrFail($id);

    // Handle image upload
    if ($request->hasFile('image')) {
        // Store new image
        $imagePath = $request->file('image')->store('productImg', 'public');
      
        $product->image = $imagePath;
    }

    // Update product fields
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->stock = $request->stock;
    $product->category_id = $request->category_id;
    $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
