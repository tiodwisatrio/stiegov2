<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                  ->orWhere('product_description', 'like', "%{$search}%");
                //   ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Archive Status Filter
        if ($request->filled('status')) {
            if ($request->status === 'archived') {
                $query->archived();
            } elseif ($request->status === 'active') {
                $query->active();
            }
            // 'all' = tidak ada filter
        }

        // Price Range Filter
        if ($request->filled('price_range')) {
            $priceRange = $request->price_range;
            if ($priceRange === '1000000+') {
                $query->where('product_price', '>=', 1000000);
            } else {
                list($min, $max) = explode('-', $priceRange);
                $query->whereBetween('product_price', [$min, $max]);
            }
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        // Hanya ambil parent categories untuk dropdown pertama
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.products.create', compact('parentCategories'));
    }

    // API endpoint untuk mendapatkan sub-categories berdasarkan parent
    public function getSubCategories($parentId)
    {
        $subCategories = Category::where('parent_id', $parentId)->get();
        return response()->json($subCategories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'product_price' => 'required|numeric|min:0',
            'product_discount' => 'nullable|integer|min:0',
            'discount_type' => 'required|in:percentage,fixed',
            'category_id' => 'required|exists:categories,id',
            'variant_size' => 'nullable|array',
            'variant_color' => 'nullable|array',
            'variant_stock' => 'nullable|array',
            'variant_price_override' => 'nullable|array',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'category_id.required' => 'Please select a sub-category for this product.',
            'category_id.exists' => 'The selected sub-category does not exist.',
            'discount_type.required' => 'Please select a discount type.',
            'discount_type.in' => 'Invalid discount type selected.'
        ]);

        // Validate discount based on type
        if ($request->discount_type === 'percentage' && $request->product_discount > 100) {
            return back()->withErrors(['product_discount' => 'Percentage discount cannot exceed 100%.'])->withInput();
        }

        $product = Product::create($request->all());

        // Simpan Variants
        if ($request->filled('variant_size')) {
            foreach ($request->variant_size as $key => $size) {
                if (!is_null($size) && !is_null($request->variant_color[$key])) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'variant_size' => $size,
                        'variant_color' => $request->variant_color[$key],
                        'stock' => $request->variant_stock[$key] ?? 0,
                        'price_override' => !empty($request->variant_price_override[$key]) ? $request->variant_price_override[$key] : null,
                    ]);
                }
            }
        }

        // Simpan Images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $parentCategories = Category::whereNull('parent_id')->get();
        $product->load('variants', 'images', 'category.parent');
        
        // Ambil parent category dari product category
        $selectedParentId = $product->category->parent_id ?? $product->category_id;
        $subCategories = Category::where('parent_id', $selectedParentId)->get();
        
        return view('admin.products.edit', compact('product', 'parentCategories', 'subCategories', 'selectedParentId'));
    }

     public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_description' => 'required|string',
            'product_price' => 'required|numeric|min:0',
            'product_discount' => 'nullable|integer|min:0',
            'discount_type' => 'required|in:percentage,fixed',
            'category_id' => 'required|exists:categories,id',
            'variant_size' => 'nullable|array',
            'variant_color' => 'nullable|array',
            'variant_stock' => 'nullable|array',
            'variant_price_override' => 'nullable|array',
            'new_images' => 'nullable|array',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'discount_type.required' => 'Please select a discount type.',
            'discount_type.in' => 'Invalid discount type selected.'
        ]);

        // Validate discount based on type
        if ($request->discount_type === 'percentage' && $request->product_discount > 100) {
            return back()->withErrors(['product_discount' => 'Percentage discount cannot exceed 100%.'])->withInput();
        }

        // Update data utama produk
        $product->update([
            'product_name' => $request->product_name,
            'product_description' => $request->product_description,
            'product_price' => $request->product_price,
            'product_discount' => $request->product_discount,
            'discount_type' => $request->discount_type,
            'category_id' => $request->category_id,
        ]);

        // Update Variants (hapus dulu, lalu tambah ulang)
        $product->variants()->delete();
        if ($request->filled('variant_size')) {
            foreach ($request->variant_size as $key => $size) {
                if (!is_null($size) && !is_null($request->variant_color[$key])) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'variant_size' => $size,
                        'variant_color' => $request->variant_color[$key],
                        'stock' => $request->variant_stock[$key] ?? 0,
                        'price_override' => $request->variant_price_override[$key] ?? null,
                    ]);
                }
            }
        }

        // Tambah gambar baru (kalau ada)
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');

    }

    // Hapus satu gambar produk
    public function destroyImage($id)
    {
        $image = ProductImage::findOrFail($id);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }


    public function destroy(Product $product)
    {
        // Hapus gambar dari storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Arsipkan product
     */
    public function archive(Product $product)
    {
        $product->archive();
        return redirect()->route('admin.products.index')->with('success', 'Product archived successfully.');
    }

    /**
     * Restore product dari arsip
     */
    public function restore(Product $product)
    {
        // Validasi: tidak bisa restore jika stock = 0
        if ($product->isOutOfStock()) {
            return redirect()->route('admin.products.index')->with('error', 'Cannot restore product: All variants are out of stock. Stock saat ini masih 0.');
        }

        $product->restore();
        return redirect()->route('admin.products.index')->with('success', 'Product restored successfully.');
    }
}