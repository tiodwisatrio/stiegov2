<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Ambil kategori dengan relasi parent dan children
        $categories = Category::with(['parent', 'children'])
            ->parents()
            ->orderBy('id', 'asc') // ✅ ganti dari ->latest() ke orderBy ID ASC
            ->paginate(10);
        
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        // Ambil semua parent categories untuk dropdown
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name',
            'category_slug' => 'required|string|max:255|unique:categories,category_slug',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        Category::create($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        // Ambil parent categories kecuali kategori saat ini (prevent circular reference)
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();
        
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name,'.$category->id,
            'category_slug' => 'required|string|max:255|unique:categories,category_slug,'.$category->id,
            'parent_id' => 'nullable|exists:categories,id|not_in:'.$category->id, // Prevent self as parent
        ]);

        $category->update($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}