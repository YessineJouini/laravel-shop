<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Display all categories
    public function index(Request $request)
    {
        $query = Category::query();

        $search = $request->input('search');
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->orderBy('name')->paginate(10);

        // Append search query to pagination links
        $categories->appends(['search' => $search]);

        return view('categories.index', compact('categories', 'search'));
    }

    // Show create form
    public function create()
    {
        return view('categories.create');
    }

    // Store new category
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        Category::create(['name' => $request->name]);

        return redirect()->route('categories.index')->with('success', 'Category created!');
    }

    // Show edit form
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Update existing category
    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255']);

        $category->update(['name' => $request->name]);

        return redirect()->route('categories.index')->with('success', 'Category updated!');
    }

    // Delete category
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted!');
    }
}
