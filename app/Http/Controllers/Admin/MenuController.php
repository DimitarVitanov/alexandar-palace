<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index()
    {
        $categories = MenuCategory::with('items')->orderBy('sort_order')->get();
        
        return Inertia::render('Admin/Menu/Index', [
            'categories' => $categories,
        ]);
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'name.mk' => 'nullable|string|max:255',
            'banner_title' => 'nullable|array',
            'banner_subtitle' => 'nullable|array',
            'banner_description' => 'nullable|array',
            'banner_image' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']['en']);
        $validated['is_active'] = $validated['is_active'] ?? true;
        $validated['sort_order'] = $validated['sort_order'] ?? MenuCategory::max('sort_order') + 1;

        MenuCategory::create($validated);

        return back()->with('success', 'Category created successfully.');
    }

    public function updateCategory(Request $request, MenuCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'name.mk' => 'nullable|string|max:255',
            'banner_title' => 'nullable|array',
            'banner_subtitle' => 'nullable|array',
            'banner_description' => 'nullable|array',
            'banner_image' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']['en']);

        $category->update($validated);

        return back()->with('success', 'Category updated successfully.');
    }

    public function destroyCategory(MenuCategory $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully.');
    }

    public function storeItem(Request $request, MenuCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'name.mk' => 'nullable|string|max:255',
            'description' => 'nullable|array',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string',
            'large_image' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['menu_category_id'] = $category->id;
        $validated['is_active'] = $validated['is_active'] ?? true;
        $validated['sort_order'] = $validated['sort_order'] ?? $category->items()->max('sort_order') + 1;

        MenuItem::create($validated);

        return back()->with('success', 'Menu item created successfully.');
    }

    public function updateItem(Request $request, MenuItem $item)
    {
        $validated = $request->validate([
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'name.mk' => 'nullable|string|max:255',
            'description' => 'nullable|array',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string',
            'large_image' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $item->update($validated);

        return back()->with('success', 'Menu item updated successfully.');
    }

    public function destroyItem(MenuItem $item)
    {
        $item->delete();
        return back()->with('success', 'Menu item deleted successfully.');
    }
}
