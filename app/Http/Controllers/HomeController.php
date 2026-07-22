<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Room;
use App\Models\Testimonial;
use App\Models\Page;
use App\Models\Setting;
use App\Services\SeoService;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __construct(
        protected SeoService $seoService
    ) {}

    public function index()
    {
        $page = Page::with('sections')->where('slug', 'home')->first();
        
        if (!$page) {
            $page = Page::create([
                'slug' => 'home',
                'title' => ['en' => 'Home', 'mk' => 'Дома'],
                'is_active' => true,
            ]);
        }

        $settings = Setting::all()->keyBy('key');
        $locale = app()->getLocale();
        
        $siteName = $this->getSettingValue($settings, 'site_name', config('app.name'));
        $siteDescription = $this->getSettingValue($settings, 'site_description', 'Luxury Hotel Experience');

        $metaTitle = $this->getTranslatedValue($page->meta_title, $locale) 
            ?: $siteName . ' - ' . $siteDescription;
        $metaDescription = $this->getTranslatedValue($page->meta_description, $locale)
            ?: $siteDescription;
        $metaKeywords = $this->getTranslatedValue($page->meta_keywords, $locale)
            ?: 'luxury hotel, accommodation, spa, restaurant, skopje, macedonia';

        $schema = [
            $this->seoService->getWebsiteSchema(),
            $this->seoService->getOrganizationSchema(),
            $this->seoService->getHotelSchema(),
            $this->seoService->getLocalBusinessSchema(),
        ];

        return Inertia::render('Home', [
            'page' => $page,
            'sections' => $page->sections->keyBy('key'),
            'rooms' => Room::active()->with('media')->orderBy('sort_order')->orderBy('id')->get(),
            'news' => News::published()->latest()->limit(3)->get(),
            'testimonials' => Testimonial::active()->latest()->limit(6)->get(),
            'settings' => $settings,
            'seo' => [
                'title' => $metaTitle,
                'description' => $metaDescription,
                'keywords' => $metaKeywords,
                'image' => $page->meta_image ?: asset('assets/paradise/img/hero_home_1.jpg'),
                'canonical' => route('home'),
                'schema' => $schema,
                'alternateUrls' => [
                    'en' => route('home', ['locale' => 'en']),
                    'mk' => route('home', ['locale' => 'mk']),
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
