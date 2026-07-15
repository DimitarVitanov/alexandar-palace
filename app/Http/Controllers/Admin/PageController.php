<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
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
            'is_active' => 'boolean',
            'meta_title' => 'nullable|array',
            'meta_description' => 'nullable|array',
        ]);

        Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', __('Page created successfully.'));
    }

    public function edit(Page $page)
    {
        return Inertia::render('Admin/Pages/Form', [
            'page' => $page->load('sections'),
        ]);
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'content' => 'nullable|array',
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
