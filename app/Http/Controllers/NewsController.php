<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Setting;
use App\Services\SeoService;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function __construct(
        protected SeoService $seoService
    ) {}

    public function index()
    {
        $news = News::published()->active()->latest()->paginate(9);
        $settings = Setting::all()->keyBy('key');
        $siteName = $this->getSettingValue($settings, 'site_name', config('app.name'));

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'News & Events'],
        ];

        return Inertia::render('News/Index', [
            'news' => $news,
            'seo' => [
                'title' => __('News & Events') . ' | ' . $siteName,
                'description' => __('Stay updated with the latest news, events, and happenings at :hotel. Discover special offers, seasonal events, and hotel updates.', ['hotel' => $siteName]),
                'keywords' => 'hotel news, events, ' . strtolower($siteName) . ', special offers, hotel updates',
                'canonical' => route('news.index'),
                'image' => $news->first()?->featured_image ? asset('assets/paradise/' . $news->first()->featured_image) : null,
                'schema' => [
                    $this->seoService->getBreadcrumbSchema($breadcrumbs),
                    [
                        '@context' => 'https://schema.org',
                        '@type' => 'CollectionPage',
                        'name' => 'News & Events',
                        'description' => 'Latest news and events from ' . $siteName,
                        'url' => route('news.index'),
                    ],
                ],
                'alternateUrls' => [
                    'en' => route('news.index', ['locale' => 'en']),
                    'mk' => route('news.index', ['locale' => 'mk']),
                ],
            ],
        ]);
    }

    public function show(News $news)
    {
        $settings = Setting::all()->keyBy('key');
        $siteName = $this->getSettingValue($settings, 'site_name', config('app.name'));
        $locale = app()->getLocale();

        $related = News::published()->active()
            ->where('id', '!=', $news->id)
            ->latest()
            ->limit(3)
            ->get();

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'News & Events', 'url' => route('news.index')],
            ['name' => $this->getTranslatedValue($news->title, $locale) ?: $news->title],
        ];

        $newsTitle = $this->getTranslatedValue($news->title, $locale) ?: $news->title;
        $newsExcerpt = $this->getTranslatedValue($news->excerpt, $locale) ?: $news->excerpt;
        $newsContent = $this->getTranslatedValue($news->content, $locale) ?: $news->content;

        return Inertia::render('News/Show', [
            'news' => $news,
            'related' => $related,
            'seo' => [
                'title' => ($news->meta_title ?? $newsTitle) . ' | ' . $siteName,
                'description' => $news->meta_description ?? strip_tags(substr($newsExcerpt ?? $newsContent ?? '', 0, 160)),
                'keywords' => $news->meta_keywords ?? $news->category . ', hotel news, ' . strtolower($siteName),
                'image' => $news->featured_image ? asset('assets/paradise/' . $news->featured_image) : null,
                'canonical' => route('news.show', $news),
                'ogType' => 'article',
                'publishedTime' => $news->published_at?->toIso8601String(),
                'modifiedTime' => $news->updated_at?->toIso8601String(),
                'section' => $news->category,
                'tags' => $news->tags ?? [],
                'schema' => [
                    $this->seoService->getBreadcrumbSchema($breadcrumbs),
                    $this->seoService->getArticleSchema($news),
                ],
                'alternateUrls' => [
                    'en' => route('news.show', ['news' => $news, 'locale' => 'en']),
                    'mk' => route('news.show', ['news' => $news, 'locale' => 'mk']),
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
