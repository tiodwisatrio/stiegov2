<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductHighlight;
use App\Models\HighlightType;
use Illuminate\Http\Request;

class ProductHighlightController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductHighlight::with(['product', 'highlightType']);

        // Search by product name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('product', function($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%');
            });
        }

        // Filter by highlight type
        if ($request->filled('highlight_type')) {
            $query->where('highlight_type_id', $request->highlight_type);
        }

        // Filter by status (active/expired)
        if ($request->filled('status')) {
            $today = today();
            if ($request->status === 'active') {
                $query->where(function($q) use ($today) {
                    $q->where('start_date', '<=', $today)
                      ->where(function($q2) use ($today) {
                          $q2->whereNull('end_date')
                             ->orWhere('end_date', '>=', $today);
                      });
                });
            } elseif ($request->status === 'expired') {
                $query->where('end_date', '<', $today);
            } elseif ($request->status === 'upcoming') {
                $query->where('start_date', '>', $today);
            }
        }

        $highlights = $query->latest()->paginate(10)->withQueryString();
        $highlightTypes = HighlightType::active()->ordered()->get();

        return view('admin.highlights.index', compact('highlights', 'highlightTypes'));
    }

    public function create()
    {
        $products = Product::all();
        $highlightTypes = HighlightType::active()->ordered()->get();
        return view('admin.highlights.create', compact('products', 'highlightTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'highlight_type_id' => 'required|exists:highlight_types,id',
            'priority' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        ProductHighlight::create($request->all());

        return redirect()->route('admin.highlights.index')->with('success', 'Highlight added successfully.');
    }

    public function edit(ProductHighlight $highlight)
    {
        $products = Product::all();
        $highlightTypes = HighlightType::active()->ordered()->get();
        return view('admin.highlights.edit', compact('highlight', 'products', 'highlightTypes'));
    }

    public function update(Request $request, ProductHighlight $highlight)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'highlight_type_id' => 'required|exists:highlight_types,id',
            'priority' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $highlight->update($request->all());

        return redirect()->route('admin.highlights.index')->with('success', 'Highlight updated successfully.');
    }

    public function destroy(ProductHighlight $highlight)
    {
        $highlight->delete();
        return redirect()->route('admin.highlights.index')->with('success', 'Highlight deleted successfully.');
    }
}
