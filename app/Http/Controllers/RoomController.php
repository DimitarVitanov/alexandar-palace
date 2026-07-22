<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Room;
use App\Models\Setting;
use App\Services\SeoService;
use Carbon\Carbon;
use Inertia\Inertia;

class RoomController extends Controller
{
    public function __construct(
        protected SeoService $seoService
    ) {}

    public function index()
    {
        $request = request();
        $adults = (int) $request->get('adults', 0);
        $children = (int) $request->get('children', 0);
        
        // Support both 'dates' range format and individual check_in/check_out params
        $checkIn = $request->get('check_in');
        $checkOut = $request->get('check_out');
        if (!$checkIn || !$checkOut) {
            [$checkIn, $checkOut] = $this->parseDateRange($request->get('dates'));
        }
        
        $totalGuests = $adults + $children;
        
        $query = Room::active()->orderBy('sort_order')->with(['media', 'units.availabilities']);
        
        if ($totalGuests > 0) {
            $query->where('max_guests', '>=', $totalGuests);
        }
        
        $rooms = $query->get();
        
        // Filter by availability using the room units system
        if ($checkIn && $checkOut) {
            $rooms = $rooms->filter(fn (Room $room) => $room->isAvailable($checkIn, $checkOut))->values();
        }
        
        $allRooms = Room::active()->orderBy('sort_order')->with('media')->get();
        
        $settings = Setting::all()->keyBy('key');
        $locale = app()->getLocale();
        
        $siteName = $this->getSettingValue($settings, 'site_name', config('app.name'));
        
        // Search parameters to pass to frontend
        $searchParams = [
            'adults' => $adults,
            'children' => $children,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'has_searched' => $totalGuests > 0 || ($checkIn && $checkOut),
            'total_results' => $rooms->count(),
            'total_rooms' => $allRooms->count(),
        ];

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Rooms & Suites'],
        ];

        // Get the rooms page for featured image
        $page = Page::where('slug', 'rooms')->first();

        return Inertia::render('Rooms/Index', [
            'rooms' => $rooms,
            'searchParams' => $searchParams,
            'featuredImage' => $page?->featured_image,
            'seo' => [
                'title' => __('Rooms & Suites') . ' | ' . $siteName,
                'description' => __('Discover our luxury rooms and suites at :hotel. Experience comfort and elegance with world-class amenities.', ['hotel' => $siteName]),
                'keywords' => 'hotel rooms, luxury suites, accommodation, ' . strtolower($siteName) . ', skopje hotel',
                'canonical' => route('rooms.index'),
                'image' => $rooms->first()?->featured_image ? asset('assets/paradise/' . $rooms->first()->featured_image) : null,
                'schema' => [
                    $this->seoService->getBreadcrumbSchema($breadcrumbs),
                    [
                        '@context' => 'https://schema.org',
                        '@type' => 'ItemList',
                        'itemListElement' => $rooms->map(fn($room, $index) => [
                            '@type' => 'ListItem',
                            'position' => $index + 1,
                            'item' => [
                                '@type' => 'HotelRoom',
                                'name' => $room->name,
                                'description' => strip_tags($room->short_description ?? ''),
                                'url' => route('rooms.show', $room),
                                'image' => $room->featured_image ? asset('assets/paradise/' . $room->featured_image) : null,
                            ],
                        ])->toArray(),
                    ],
                ],
                'alternateUrls' => [
                    'en' => route('rooms.index', ['locale' => 'en']),
                    'mk' => route('rooms.index', ['locale' => 'mk']),
                ],
            ],
        ]);
    }

    public function show(Room $room)
    {
        $room->load('media');
        $settings = Setting::all()->keyBy('key');
        $siteName = $this->getSettingValue($settings, 'site_name', config('app.name'));
        $locale = app()->getLocale();

        $relatedRooms = Room::active()
            ->where('id', '!=', $room->id)
            ->limit(3)
            ->get();

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Rooms & Suites', 'url' => route('rooms.index')],
            ['name' => $room->name],
        ];

        $roomName = $this->getTranslatedValue($room->name, $locale) ?: $room->name;
        $roomDescription = $this->getTranslatedValue($room->description, $locale) ?: $room->description;

        return Inertia::render('Rooms/Show', [
            'room' => $room,
            'relatedRooms' => $relatedRooms,
            'seo' => [
                'title' => ($room->meta_title ?? $roomName) . ' | ' . $siteName,
                'description' => $room->meta_description ?? strip_tags(substr($roomDescription ?? '', 0, 160)),
                'keywords' => $room->meta_keywords ?? 'hotel room, ' . strtolower($roomName) . ', luxury accommodation, ' . strtolower($siteName),
                'image' => $room->featured_image ? asset('assets/paradise/' . $room->featured_image) : null,
                'canonical' => route('rooms.show', $room),
                'schema' => [
                    $this->seoService->getBreadcrumbSchema($breadcrumbs),
                    $this->seoService->getRoomSchema($room),
                ],
                'alternateUrls' => [
                    'en' => route('rooms.show', ['room' => $room, 'locale' => 'en']),
                    'mk' => route('rooms.show', ['room' => $room, 'locale' => 'mk']),
                ],
            ],
        ]);
    }

    private function parseDateRange(?string $dates): array
    {
        if (!$dates || !str_contains($dates, ' - ')) {
            return [null, null];
        }

        [$checkIn, $checkOut] = array_map('trim', explode(' - ', $dates, 2));

        try {
            return [
                Carbon::createFromFormat('m/d/Y', $checkIn)->toDateString(),
                Carbon::createFromFormat('m/d/Y', $checkOut)->toDateString(),
            ];
        } catch (\Exception) {
            return [null, null];
        }
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
