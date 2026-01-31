<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Hanya tampilkan product yang tidak diarsip
        $query = Product::with(['category.parent', 'images'])->active();

        // Search by product name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('product_name', 'like', "%{$search}%");
        }

        // Filter by Category (parent or sub-category)
        if ($request->filled('category')) {
            $categorySlugOrId = $request->category;

            // Try to find by slug first, then by ID
            $category = Category::where('category_slug', $categorySlugOrId)
                ->orWhere('id', $categorySlugOrId)
                ->first();

            if ($category) {
                // Jika parent category, ambil semua products dari sub-categories
                if ($category->isParent()) {
                    $categoryIds = $category->children->pluck('id')->toArray();
                    $categoryIds[] = $category->id; // Include parent juga
                    $query->whereIn('category_id', $categoryIds);
                } else {
                    // Jika sub-category, filter langsung
                    $query->where('category_id', $category->id);
                }
            }
        }

        // Filter by Price Range
        if ($request->filled('price_min')) {
            $query->where('product_price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('product_price', '<=', $request->price_max);
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('product_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('product_price', 'desc');
                break;
            case 'name':
                $query->orderBy('product_name', 'asc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        
        // Get all categories untuk filter dropdown
        $parentCategories = Category::whereNull('parent_id')
            ->with('children')
            ->get();

        return view('frontend.products.index', compact('products', 'parentCategories'));
    }

    public function show(Product $product)
    {
        // Redirect jika product diarsip
        if ($product->isArchived()) {
            abort(404);
        }

        $product->load(['category.parent', 'images', 'variants']);
        return view('frontend.products.show', compact('product'));
    }
}