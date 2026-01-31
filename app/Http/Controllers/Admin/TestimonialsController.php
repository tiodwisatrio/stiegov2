<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialsController extends Controller
{
    public function index()
    {
        $testimonials = Testimonials::latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'testimonial_name' => 'required|string|max:255',
            'testimonial_description' => 'required|string',
            'testimonial_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'testimonial_rating' => 'required|integer|min:1|max:5',
            'testimonial_position' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('testimonial_image')) {
            $validated['testimonial_image'] = $request->file('testimonial_image')->store('testimonials', 'public');
        }

        Testimonials::create($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function edit(Testimonials $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonials $testimonial)
    {
        $validated = $request->validate([
            'testimonial_name' => 'required|string|max:255',
            'testimonial_description' => 'required|string',
            'testimonial_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'testimonial_rating' => 'required|integer|min:1|max:5',
            'testimonial_position' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('testimonial_image')) {
            if ($testimonial->testimonial_image) {
                Storage::disk('public')->delete($testimonial->testimonial_image);
            }
            $validated['testimonial_image'] = $request->file('testimonial_image')->store('testimonials', 'public');
        }

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonials $testimonial)
    {
        if ($testimonial->testimonial_image) {
            Storage::disk('public')->delete($testimonial->testimonial_image);
        }
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully.');
    }
}
