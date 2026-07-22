<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Traits\HandlesBilingualFields;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    use HandlesBilingualFields;
    public function index()
    {
        return Inertia::render('Admin/Pages/Index', [
            'pages' => Page::withCount('sections')->orderBy('sort_order')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Pages/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:pages',
            'title' => 'required|array',
            'content' => 'nullable|array',
            'featured_image' => 'nullable|string',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|array',
            'meta_description' => 'nullable|array',
        ]);

        Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', __('Page created successfully.'));
    }

    public function edit(Page $page)
    {
        $pageData = $this->prepareBilingualData(
            $page->load('sections'),
            ['title', 'content', 'meta_title', 'meta_description']
        );
        
        return Inertia::render('Admin/Pages/Form', [
            'page' => $pageData,
        ]);
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'content' => 'nullable|array',
            'featured_image' => 'nullable|string',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|array',
            'meta_description' => 'nullable|array',
        ]);

        $page->update($validated);

        return back()->with('success', __('Page updated successfully.'));
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return back()->with('success', __('Page deleted successfully.'));
    }
}
