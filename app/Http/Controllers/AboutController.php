<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageSection;
use App\Models\Testimonial;
use App\Models\Setting;
use Inertia\Inertia;

class AboutController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();
        
        $page = Page::where('slug', 'about')->first();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->get();
        $settings = Setting::all()->keyBy('key');
        
        // Fetch all about page sections
        $sections = PageSection::where('page_id', $page?->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('key')
            ->map(function ($section) use ($locale) {
                return [
                    'title' => $section->getTranslation('title', $locale),
                    'subtitle' => $section->getTranslation('subtitle', $locale),
                    'content' => $section->getTranslation('content', $locale),
                    'image' => $section->image,
                    'data' => $section->data,
                ];
            });

        $seo = [
            'title' => $page?->getTranslation('meta_title', $locale) ?? 'About Us - Alexandar Palace Hotel',
            'description' => $page?->getTranslation('meta_description', $locale) ?? 'Learn about Alexandar Palace Hotel, our history, facilities, and commitment to luxury hospitality.',
            'keywords' => $page?->meta_keywords ?? 'about, hotel, alexandar palace, history, facilities',
            'image' => $page?->featured_image ? asset('assets/paradise/' . $page->featured_image) : asset('assets/paradise/img/hero_home_1.jpg'),
            'canonical' => route('about'),
            'alternateUrls' => [
                'en' => route('about', ['locale' => 'en']),
                'mk' => route('about', ['locale' => 'mk']),
            ],
        ];

        return Inertia::render('About', [
            'page' => $page,
            'sections' => $sections,
            'testimonials' => $testimonials,
            'settings' => $settings,
            'seo' => $seo,
        ]);
    }
}
