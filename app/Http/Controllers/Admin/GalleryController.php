<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use App\Traits\HandlesBilingualFields;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GalleryController extends Controller
{
    use HandlesBilingualFields;
    public function index()
    {
        return Inertia::render('Admin/Gallery/Index', [
            'items' => GalleryItem::orderBy('sort_order')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Gallery/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'nullable|string',
            'image' => 'required|string',
            'title' => 'nullable|array',
            'description' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        GalleryItem::create($validated);

        return redirect()->route('admin.gallery.index')->with('success', __('Gallery item created successfully.'));
    }

    public function edit(GalleryItem $gallery)
    {
        $itemData = $this->prepareBilingualData(
            $gallery,
            ['title', 'description']
        );
        
        return Inertia::render('Admin/Gallery/Form', [
            'item' => $itemData,
        ]);
    }

    public function update(Request $request, GalleryItem $gallery)
    {
        $validated = $request->validate([
            'category' => 'nullable|string',
            'image' => 'required|string',
            'title' => 'nullable|array',
            'description' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $gallery->update($validated);

        return back()->with('success', __('Gallery item updated successfully.'));
    }

    public function destroy(GalleryItem $gallery)
    {
        $gallery->delete();

        return back()->with('success', __('Gallery item deleted successfully.'));
    }
}
