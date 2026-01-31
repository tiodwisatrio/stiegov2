<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HighlightType;
use App\Models\ProductHighlight;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        // Get all active highlight types
        $highlightTypes = HighlightType::active()->ordered()->get();

        $today = today();

        // Get all highlights grouped by type
        $groupedHighlights = [];

        foreach($highlightTypes as $type) {
            $typeHighlights = ProductHighlight::with(['product.images', 'product.category', 'product.variants'])
                ->where('highlight_type_id', $type->id)
                ->where(function ($query) use ($today) {
                    $query->whereDate('start_date', '<=', $today)
                          ->orWhereNull('start_date');
                })
                ->where(function ($query) use ($today) {
                    $query->whereDate('end_date', '>=', $today)
                          ->orWhereNull('end_date');
                })
                ->orderBy('priority', 'asc')
                ->orderBy('created_at', 'desc')
                ->get()
                ->filter(function ($highlight) {
                    return $highlight->product &&
                           !$highlight->product->is_archived &&
                           $highlight->product->variants &&
                           $highlight->product->variants->sum('stock') > 0;
                });

            if ($typeHighlights->isNotEmpty()) {
                $groupedHighlights[] = [
                    'type' => $type,
                    'highlights' => $typeHighlights
                ];
            }
        }

        return view('frontend.catalog.index', compact('highlightTypes', 'groupedHighlights'));
    }

    public function bySlug($slug)
    {
        // Get highlight type by slug
        $highlightType = HighlightType::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get all active highlight types for tabs
        $highlightTypes = HighlightType::active()->ordered()->get();

        // Ambil products berdasarkan highlight type
        $today = today();

        $highlights = ProductHighlight::with(['product.images', 'product.category', 'product.variants'])
            ->where('highlight_type_id', $highlightType->id)
            ->where(function ($query) use ($today) {
                $query->whereDate('start_date', '<=', $today)
                      ->orWhereNull('start_date');
            })
            ->where(function ($query) use ($today) {
                $query->whereDate('end_date', '>=', $today)
                      ->orWhereNull('end_date');
            })
            ->orderBy('priority', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Filter manual products yang aktif (tidak diarsip) dan punya variant dengan stock > 0
        $highlights = $highlights->filter(function ($highlight) {
            return $highlight->product &&
                   !$highlight->product->is_archived &&
                   $highlight->product->variants &&
                   $highlight->product->variants->sum('stock') > 0;
        });

        return view('frontend.catalog.type', compact('highlights', 'highlightType', 'highlightTypes'));
    }
}
