<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'locale' => fn () => app()->getLocale(),
            'translations' => fn () => [
                'en' => __('messages.en'),
                'mk' => __('messages.mk'),
            ],
            'flash' => fn () => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
            'seo' => fn () => [
                'site_name' => config('app.name'),
                'default_description' => config('seo.default_description'),
                'default_image' => config('seo.default_image'),
                'locale' => app()->getLocale(),
                'alternate_locales' => ['en', 'mk'],
            ],
            'auth' => fn () => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'is_admin' => $request->user()->is_admin ?? false,
                ] : null,
            ],
        ];
    }
}
