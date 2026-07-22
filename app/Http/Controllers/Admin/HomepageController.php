<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use App\Traits\HandlesBilingualFields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HomepageController extends Controller
{
    use HandlesBilingualFields;
    public function index()
    {
        $homepage = Page::where('slug', 'home')->first();
        
        if (!$homepage) {
            $homepage = Page::create([
                'slug' => 'home',
                'title' => ['en' => 'Home', 'mk' => 'Дома'],
                'is_active' => true,
            ]);
        }

        $sections = $homepage->sections()->orderBy('sort_order')->get()->keyBy('key');
        
        // Convert each section's bilingual fields - get raw attributes to avoid Translatable trait localization
        $preparedSections = [];
        foreach ($sections as $key => $section) {
            $sectionData = $section->getAttributes();
            $sectionData['id'] = $section->id;
            
            // Decode JSON fields
            foreach (['title', 'subtitle', 'content', 'data'] as $field) {
                if (isset($sectionData[$field]) && is_string($sectionData[$field])) {
                    $decoded = json_decode($sectionData[$field], true);
                    $sectionData[$field] = $decoded;
                }
            }
            
            $preparedSections[$key] = $this->prepareBilingualData(
                $sectionData,
                ['title', 'subtitle', 'content']
            );
        }

        return Inertia::render('Admin/Homepage/Index', [
            'homepage' => $homepage,
            'sections' => $preparedSections,
            'sectionTypes' => $this->getSectionTypes(),
        ]);
    }

    public function update(Request $request)
    {
        $homepage = Page::where('slug', 'home')->firstOrFail();

        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*.key' => 'required|string',
            'sections.*.title' => 'nullable|array',
            'sections.*.subtitle' => 'nullable|array',
            'sections.*.content' => 'nullable|array',
            'sections.*.image' => 'nullable|string',
            'sections.*.video' => 'nullable|string',
            'sections.*.data' => 'nullable|array',
            'sections.*.is_active' => 'boolean',
        ]);

        foreach ($validated['sections'] as $sectionData) {
            PageSection::updateOrCreate(
                [
                    'page_id' => $homepage->id,
                    'key' => $sectionData['key'],
                ],
                [
                    'title' => $sectionData['title'] ?? null,
                    'subtitle' => $sectionData['subtitle'] ?? null,
                    'content' => $sectionData['content'] ?? null,
                    'image' => $sectionData['image'] ?? null,
                    'video' => $sectionData['video'] ?? null,
                    'data' => $sectionData['data'] ?? null,
                    'is_active' => $sectionData['is_active'] ?? true,
                ]
            );
        }

        return back()->with('success', 'Homepage updated successfully.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
        ]);

        $path = $request->file('image')->store('homepage', 'public');

        return response()->json([
            'path' => $path,
            'url' => Storage::url($path),
        ]);
    }

    private function getSectionTypes(): array
    {
        return [
            'hero' => [
                'label' => 'Hero Section',
                'fields' => ['title', 'subtitle', 'video'],
            ],
            'about' => [
                'label' => 'About Section',
                'fields' => ['title', 'subtitle', 'content', 'image'],
            ],
            'video_parallax' => [
                'label' => 'Video Parallax',
                'fields' => ['title', 'subtitle', 'video'],
            ],
            'facilities' => [
                'label' => 'Facilities',
                'fields' => ['title', 'subtitle', 'data'],
            ],
            'local_amenities' => [
                'label' => 'Local Amenities',
                'fields' => ['title', 'subtitle', 'data'],
            ],
            'booking' => [
                'label' => 'Booking Section',
                'fields' => ['title', 'subtitle', 'content'],
            ],
        ];
    }
}
