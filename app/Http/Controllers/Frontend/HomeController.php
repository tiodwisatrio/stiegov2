<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\HighlightType;
use App\Models\ProductHighlight;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the homepage with active banners and dynamic highlight sections
     */
    public function index(): View
    {
        $banners = Banner::where('banner_status', 1)->get();

        // Get all active highlight types with their products
        $highlightSections = HighlightType::active()
            ->ordered()
            ->get()
            ->map(function($highlightType) {
                $products = ProductHighlight::with('product.images', 'product.category', 'product.variants')
                    ->where('highlight_type_id', $highlightType->id)
                    ->whereHas('product', function($query) {
                        $query->where('is_archived', false);
                    })
                    ->whereDate('start_date', '<=', today())
                    ->where(function($query) {
                        $query->whereNull('end_date')
                              ->orWhereDate('end_date', '>=', today());
                    })
                    ->latest()
                    ->get()
                    ->filter(function($highlight) {
                        // Filter produk yang punya variant dengan stock > 0
                        return $highlight->product &&
                               $highlight->product->variants &&
                               $highlight->product->variants->sum('stock') > 0;
                    })
                    ->take(4)
                    ->map(function($highlight) {
                        return $highlight->product;
                    });

                return [
                    'type' => $highlightType,
                    'products' => $products,
                ];
            })
            ->filter(function($section) {
                // Only include sections that have products
                return $section['products']->isNotEmpty();
            });

        // Get testimonials data
        $testimonials = \App\Models\Testimonials::select(
            'testimonial_name as name',
            'testimonial_position as position',
            'testimonial_rating as rating',
            'testimonial_description as message',
            'testimonial_image as image'
        )->get();

        // Convert image path to full URL using Storage::url()
        foreach ($testimonials as $item) {
            $item->image = \Storage::url($item->image);
        }

        return view('frontend.home', [
            'banners' => $banners,
            'highlightSections' => $highlightSections,
            'testimonials' => $testimonials
        ]);
    }
}
