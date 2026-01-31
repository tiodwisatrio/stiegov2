<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
{
        $validated = $request->validate([
            'banner_title' => 'required|string|max:255',
            'banner_subtitle' => 'nullable|string|max:255',
            'banner_description' => 'nullable|string',
            'banner_type' => 'required|in:image,video',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_video_url' => 'nullable|string|max:255',
            'banner_button_text' => 'nullable|string|max:100',
            'banner_button_link' => 'nullable|string|max:255',
            'banner_position' => 'nullable|string|max:100',
            'banner_order' => 'nullable|integer',
            'banner_status' => 'required|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Wajib isi image atau video tergantung type
        if ($validated['banner_type'] === 'image' && !$request->hasFile('banner_image')) {
            return back()->withErrors(['banner_image' => 'Image is required when type is image.'])->withInput();
        }

        if ($validated['banner_type'] === 'video' && !$request->banner_video_url) {
            return back()->withErrors(['banner_video_url' => 'Video URL is required when type is video.'])->withInput();
        }

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('banners', 'public');
        }

        Banner::create($validated);

    return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully!');
}

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

   public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'banner_title' => 'required|string|max:255',
            'banner_subtitle' => 'nullable|string|max:255',
            'banner_description' => 'nullable|string',
            'banner_type' => 'required|in:image,video',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_video_url' => 'nullable|string|max:255',
            'banner_button_text' => 'nullable|string|max:100',
            'banner_button_link' => 'nullable|string|max:255',
            'banner_position' => 'nullable|string|max:100',
            'banner_order' => 'nullable|integer',
            'banner_status' => 'required|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($validated['banner_type'] === 'image' && !$banner->banner_image && !$request->hasFile('banner_image')) {
            return back()->withErrors(['banner_image' => 'Image is required when type is image.'])->withInput();
        }

        if ($validated['banner_type'] === 'video' && !$request->banner_video_url) {
            return back()->withErrors(['banner_video_url' => 'Video URL is required when type is video.'])->withInput();
        }

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('banners', 'public');
        }

        $banner->update($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully!');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->banner_image) {
            Storage::disk('public')->delete($banner->banner_image);
        }

        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully!');
    }
}
