<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use App\Models\Page;
use App\Models\Setting;
use App\Services\SeoService;
use Inertia\Inertia;

class RestaurantController extends Controller
{
    public function __construct(
        protected SeoService $seoService
    ) {}

    public function index()
    {
        $page = Page::with('sections')->where('slug', 'restaurant')->active()->first();
        $settings = Setting::all()->keyBy('key');
        $siteName = $this->getSettingValue($settings, 'site_name', config('app.name'));
        $locale = app()->getLocale();

        $pageTitle = 'Restaurant';
        $pageDescription = 'Experience culinary excellence at Alexandar Palace Hotel restaurant';

        if ($page) {
            $pageTitle = $this->getTranslatedValue($page->title, $locale) ?: $page->title;
            $pageDescription = $this->getTranslatedValue($page->meta_description, $locale) 
                ?: $this->getTranslatedValue($page->content, $locale);
        }

        // Get menu categories with items
        $menuCategories = MenuCategory::with('activeItems')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => $pageTitle],
        ];

        $canonicalUrl = url('/restaurant');

        return Inertia::render('Restaurant', [
            'page' => $page,
            'sections' => $page?->sections->keyBy('key') ?? collect(),
            'menuCategories' => $menuCategories,
            'seo' => [
                'title' => ($page?->meta_title ?? $pageTitle) . ' | ' . $siteName,
                'description' => strip_tags(substr($pageDescription ?? '', 0, 160)),
                'keywords' => $this->getTranslatedValue($page?->meta_keywords, $locale) 
                    ?: 'restaurant, dining, macedonian cuisine, alexandar palace',
                'image' => $page?->meta_image ?: asset('assets/paradise/img/restaurant/slides/slide_1.jpg'),
                'canonical' => $canonicalUrl,
                'schema' => [
                    $this->seoService->getBreadcrumbSchema($breadcrumbs),
                    [
                        '@context' => 'https://schema.org',
                        '@type' => 'Restaurant',
                        'name' => 'Alexandar Palace Restaurant',
                        'description' => strip_tags(substr($pageDescription ?? '', 0, 160)),
                        'url' => $canonicalUrl,
                        'servesCuisine' => ['Macedonian', 'International'],
                        'priceRange' => '$$',
                    ],
                ],
                'alternateUrls' => [
                    'en' => url('/restaurant', ['locale' => 'en']),
                    'mk' => url('/restaurant', ['locale' => 'mk']),
                ],
            ],
        ]);
    }

    private function getSettingValue($settings, string $key, $default = '')
    {
        $setting = $settings->get($key);
        if (!$setting) return $default;
        
        $value = $setting->value;
        if (is_array($value)) {
            return $value[app()->getLocale()] ?? $value['en'] ?? $default;
        }
        return $value ?? $default;
    }

    private function getTranslatedValue($value, string $locale)
    {
        if (!$value) return null;
        if (is_array($value)) {
            return $value[$locale] ?? $value['en'] ?? null;
        }
        return $value;
    }
}
