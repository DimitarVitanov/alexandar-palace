<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TestimonialController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Testimonials/Index', [
            'testimonials' => Testimonial::orderBy('sort_order')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Testimonials/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'location' => 'nullable|string',
            'comment' => 'required|string',
            'rating' => 'integer|min:1|max:5',
            'is_active' => 'boolean',
        ]);

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')->with('success', __('Testimonial created successfully.'));
    }

    public function edit(Testimonial $testimonial)
    {
        return Inertia::render('Admin/Testimonials/Form', [
            'testimonial' => $testimonial,
        ]);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'location' => 'nullable|string',
            'comment' => 'required|string',
            'rating' => 'integer|min:1|max:5',
            'is_active' => 'boolean',
        ]);

        $testimonial->update($validated);

        return back()->with('success', __('Testimonial updated successfully.'));
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return back()->with('success', __('Testimonial deleted successfully.'));
    }
}
