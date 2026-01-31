<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HighlightType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HighlightTypeController extends Controller
{
    public function index()
    {
        $highlightTypes = HighlightType::orderBy('display_order')->paginate(10);
        return view('admin.highlight_types.index', compact('highlightTypes'));
    }

    public function create()
    {
        return view('admin.highlight_types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:highlight_types,slug',
            'description' => 'nullable|string',
            'banner_desktop' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'display_order' => 'nullable|integer',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle banner desktop upload
        if ($request->hasFile('banner_desktop')) {
            $validated['banner_desktop'] = $request->file('banner_desktop')->store('highlight_banners/desktop', 'public');
        }

        // Handle banner mobile upload
        if ($request->hasFile('banner_mobile')) {
            $validated['banner_mobile'] = $request->file('banner_mobile')->store('highlight_banners/mobile', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        HighlightType::create($validated);

        return redirect()->route('admin.highlight-types.index')
                         ->with('success', 'Highlight type created successfully.');
    }

    public function edit(HighlightType $highlightType)
    {
        return view('admin.highlight_types.edit', compact('highlightType'));
    }

    public function update(Request $request, HighlightType $highlightType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:highlight_types,slug,' . $highlightType->id,
            'description' => 'nullable|string',
            'banner_desktop' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'display_order' => 'nullable|integer',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle banner desktop upload
        if ($request->hasFile('banner_desktop')) {
            // Delete old banner
            if ($highlightType->banner_desktop) {
                Storage::disk('public')->delete($highlightType->banner_desktop);
            }
            $validated['banner_desktop'] = $request->file('banner_desktop')->store('highlight_banners/desktop', 'public');
        }

        // Handle banner mobile upload
        if ($request->hasFile('banner_mobile')) {
            // Delete old banner
            if ($highlightType->banner_mobile) {
                Storage::disk('public')->delete($highlightType->banner_mobile);
            }
            $validated['banner_mobile'] = $request->file('banner_mobile')->store('highlight_banners/mobile', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $highlightType->update($validated);

        return redirect()->route('admin.highlight-types.index')
                         ->with('success', 'Highlight type updated successfully.');
    }

    public function destroy(HighlightType $highlightType)
    {
        // Count product highlights that will be deleted
        $productHighlightsCount = $highlightType->productHighlights()->count();

        // Delete all product highlights associated with this highlight type
        $highlightType->productHighlights()->delete();

        // Delete banners
        if ($highlightType->banner_desktop) {
            Storage::disk('public')->delete($highlightType->banner_desktop);
        }
        if ($highlightType->banner_mobile) {
            Storage::disk('public')->delete($highlightType->banner_mobile);
        }

        $highlightType->delete();

        $message = 'Highlight type deleted successfully.';
        if ($productHighlightsCount > 0) {
            $message .= " ({$productHighlightsCount} product highlight(s) were also removed)";
        }

        return redirect()->route('admin.highlight-types.index')
                         ->with('success', $message);
    }
}
