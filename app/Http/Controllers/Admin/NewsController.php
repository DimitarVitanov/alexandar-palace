<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/News/Index', [
            'news' => News::latest()->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/News/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:news',
            'title' => 'required|array',
            'excerpt' => 'nullable|array',
            'content' => 'nullable|array',
            'category' => 'nullable|string',
            'published_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        News::create($validated);

        return redirect()->route('admin.news.index')->with('success', __('News created successfully.'));
    }

    public function edit(News $news)
    {
        return Inertia::render('Admin/News/Form', [
            'news' => $news,
        ]);
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'excerpt' => 'nullable|array',
            'content' => 'nullable|array',
            'category' => 'nullable|string',
            'published_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $news->update($validated);

        return back()->with('success', __('News updated successfully.'));
    }

    public function destroy(News $news)
    {
        $news->delete();

        return back()->with('success', __('News deleted successfully.'));
    }
}
