<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Setting;
use App\Services\SeoService;
use Inertia\Inertia;

class PageController extends Controller
{
    public function __construct(
        protected SeoService $seoService
    ) {}

    public function show(string $slug)
    {
        $page = Page::with('sections')->where('slug', $slug)->active()->firstOrFail();
        $settings = Setting::all()->keyBy('key');
        $siteName = $this->getSettingValue($settings, 'site_name', config('app.name'));
        $locale = app()->getLocale();

        $pageTitle = $this->getTranslatedValue($page->title, $locale) ?: $page->title;
        $pageDescription = $this->getTranslatedValue($page->meta_description, $locale) 
            ?: $this->getTranslatedValue($page->content, $locale);

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => $pageTitle],
        ];

        $canonicalUrl = url("/{$slug}");

        return Inertia::render('Page', [
            'page' => $page,
            'sections' => $page->sections->keyBy('key'),
            'seo' => [
                'title' => ($page->meta_title ?? $pageTitle) . ' | ' . $siteName,
                'description' => strip_tags(substr($pageDescription ?? '', 0, 160)),
                'keywords' => $this->getTranslatedValue($page->meta_keywords, $locale) 
                    ?: strtolower($pageTitle) . ', ' . strtolower($siteName),
                'image' => $page->meta_image ?: asset('assets/paradise/img/hero_home_1.jpg'),
                'canonical' => $canonicalUrl,
                'schema' => [
                    $this->seoService->getBreadcrumbSchema($breadcrumbs),
                    [
                        '@context' => 'https://schema.org',
                        '@type' => 'WebPage',
                        'name' => $pageTitle,
                        'description' => strip_tags(substr($pageDescription ?? '', 0, 160)),
                        'url' => $canonicalUrl,
                        'isPartOf' => [
                            '@type' => 'WebSite',
                            'name' => $siteName,
                            'url' => config('app.url'),
                        ],
                    ],
                ],
                'alternateUrls' => [
                    'en' => url("/{$slug}", ['locale' => 'en']),
                    'mk' => url("/{$slug}", ['locale' => 'mk']),
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
