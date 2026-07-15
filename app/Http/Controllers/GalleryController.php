<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use App\Models\Setting;
use App\Services\SeoService;
use Inertia\Inertia;

class GalleryController extends Controller
{
    public function __construct(
        protected SeoService $seoService
    ) {}

    public function index()
    {
        $items = GalleryItem::active()->orderBy('sort_order')->get();
        $settings = Setting::all()->keyBy('key');
        $siteName = $this->getSettingValue($settings, 'site_name', config('app.name'));

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Gallery'],
        ];

        return Inertia::render('Gallery', [
            'items' => $items->groupBy('category'),
            'seo' => [
                'title' => __('Gallery') . ' | ' . $siteName,
                'description' => __('Explore our photo gallery and discover the beauty of :hotel. View our luxurious rooms, amenities, spa, restaurant, and stunning surroundings.', ['hotel' => $siteName]),
                'keywords' => 'hotel gallery, photos, ' . strtolower($siteName) . ', hotel images, luxury hotel photos',
                'image' => $items->first()?->image ? asset('assets/paradise/' . $items->first()->image) : null,
                'canonical' => route('gallery'),
                'schema' => [
                    $this->seoService->getBreadcrumbSchema($breadcrumbs),
                    [
                        '@context' => 'https://schema.org',
                        '@type' => 'ImageGallery',
                        'name' => $siteName . ' Photo Gallery',
                        'description' => 'Photo gallery of ' . $siteName,
                        'url' => route('gallery'),
                        'image' => $items->take(10)->map(fn($item) => asset('assets/paradise/' . $item->image))->toArray(),
                    ],
                ],
                'alternateUrls' => [
                    'en' => route('gallery', ['locale' => 'en']),
                    'mk' => route('gallery', ['locale' => 'mk']),
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
}
