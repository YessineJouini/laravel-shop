<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Sale::with('product');

        if ($search) {
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $sales = $query->paginate(10)->appends(['search' => $search]);

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id'       => 'required|exists:products,id|unique:sales,product_id',
            'discount_percent' => 'required|integer|min:1|max:100',
            'start_date'       => 'nullable|date',
            'end_date'         => 'nullable|date|after_or_equal:start_date',
        ]);

        Sale::create($data);
        return redirect()->route('sales.index')->with('success', 'Sale created.');
    }

    public function edit(Sale $sale)
    {
        $products = Product::all();
        return view('sales.edit', compact('sale', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        $data = $request->validate([
            'product_id'       => 'required|exists:products,id|unique:sales,product_id,' . $sale->id,
            'discount_percent' => 'required|integer|min:1|max:100',
            'start_date'       => 'nullable|date',
            'end_date'         => 'nullable|date|after_or_equal:start_date',
        ]);

        $sale->update($data);
        return redirect()->route('sales.index')->with('success', 'Sale updated.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale removed.');
    }
    
    public function viewSales()
    {
        $sales = Sale::with('product')->paginate(9);
        $categories = Category::all();
        $layout = (Auth::check() && Auth::user()->role === 'admin')
            ? 'layout'
            : 'layouts.app';
        return view('sales.view', compact('sales', 'layout'));
    }
}
