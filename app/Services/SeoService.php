<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\URL;

class SeoService
{
    public function getHotelSchema(): array
    {
        $settings = Setting::all()->keyBy('key');
        
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Hotel',
            'name' => $this->getSetting($settings, 'site_name', config('app.name')),
            'description' => $this->getSetting($settings, 'site_description', ''),
            'url' => config('app.url'),
            'logo' => asset('assets/paradise/img/logo.svg'),
            'image' => $this->getSetting($settings, 'og_image', asset('assets/paradise/img/hero_home_1.jpg')),
            'telephone' => $this->getSetting($settings, 'phone', ''),
            'email' => $this->getSetting($settings, 'email', ''),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $this->getSetting($settings, 'address', ''),
                'addressLocality' => $this->getSetting($settings, 'city', 'Skopje'),
                'addressRegion' => $this->getSetting($settings, 'region', ''),
                'postalCode' => $this->getSetting($settings, 'postal_code', ''),
                'addressCountry' => $this->getSetting($settings, 'country', 'MK'),
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $this->getSetting($settings, 'latitude', ''),
                'longitude' => $this->getSetting($settings, 'longitude', ''),
            ],
            'priceRange' => $this->getSetting($settings, 'price_range', '€€€'),
            'starRating' => [
                '@type' => 'Rating',
                'ratingValue' => $this->getSetting($settings, 'star_rating', '5'),
            ],
            'amenityFeature' => $this->getAmenities($settings),
            'checkinTime' => $this->getSetting($settings, 'checkin_time', '14:00'),
            'checkoutTime' => $this->getSetting($settings, 'checkout_time', '11:00'),
            'currenciesAccepted' => 'EUR, MKD',
            'paymentAccepted' => 'Cash, Credit Card, Debit Card',
            'sameAs' => array_filter([
                $this->getSetting($settings, 'facebook_url', ''),
                $this->getSetting($settings, 'instagram_url', ''),
                $this->getSetting($settings, 'twitter_url', ''),
                $this->getSetting($settings, 'linkedin_url', ''),
                $this->getSetting($settings, 'youtube_url', ''),
                $this->getSetting($settings, 'tripadvisor_url', ''),
            ]),
        ];
    }

    public function getRoomSchema($room): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'HotelRoom',
            'name' => $room->name,
            'description' => strip_tags($room->description ?? ''),
            'image' => $room->featured_image ? asset('assets/paradise/' . $room->featured_image) : null,
            'occupancy' => [
                '@type' => 'QuantitativeValue',
                'maxValue' => $room->max_guests ?? 2,
            ],
            'bed' => [
                '@type' => 'BedDetails',
                'typeOfBed' => $room->bed_type ?? 'King',
                'numberOfBeds' => $room->beds ?? 1,
            ],
            'amenityFeature' => collect($room->amenities ?? [])->map(fn($a) => [
                '@type' => 'LocationFeatureSpecification',
                'name' => $a,
                'value' => true,
            ])->toArray(),
            'offers' => [
                '@type' => 'Offer',
                'price' => $room->price_per_night,
                'priceCurrency' => 'EUR',
                'availability' => 'https://schema.org/InStock',
                'validFrom' => now()->toIso8601String(),
            ],
        ];
    }

    public function getArticleSchema($article): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $article->title,
            'description' => strip_tags($article->excerpt ?? $article->content ?? ''),
            'image' => $article->featured_image ? asset('assets/paradise/' . $article->featured_image) : null,
            'datePublished' => $article->published_at?->toIso8601String(),
            'dateModified' => $article->updated_at?->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('assets/paradise/img/logo.svg'),
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => url()->current(),
            ],
        ];
    }

    public function getBreadcrumbSchema(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($items)->map(fn($item, $index) => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'] ?? null,
            ])->toArray(),
        ];
    }

    public function getFAQSchema(array $faqs): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => collect($faqs)->map(fn($faq) => [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer'],
                ],
            ])->toArray(),
        ];
    }

    public function getLocalBusinessSchema(): array
    {
        $settings = Setting::all()->keyBy('key');
        
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LodgingBusiness',
            'name' => $this->getSetting($settings, 'site_name', config('app.name')),
            'description' => $this->getSetting($settings, 'site_description', ''),
            'url' => config('app.url'),
            'telephone' => $this->getSetting($settings, 'phone', ''),
            'email' => $this->getSetting($settings, 'email', ''),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $this->getSetting($settings, 'address', ''),
                'addressLocality' => $this->getSetting($settings, 'city', 'Skopje'),
                'addressCountry' => 'MK',
            ],
            'openingHoursSpecification' => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'opens' => '00:00',
                'closes' => '23:59',
            ],
        ];
    }

    public function getWebsiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('app.name'),
            'url' => config('app.url'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => config('app.url') . '/search?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    public function getOrganizationSchema(): array
    {
        $settings = Setting::all()->keyBy('key');
        
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $this->getSetting($settings, 'site_name', config('app.name')),
            'url' => config('app.url'),
            'logo' => asset('assets/paradise/img/logo.svg'),
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => $this->getSetting($settings, 'phone', ''),
                'contactType' => 'reservations',
                'availableLanguage' => ['English', 'Macedonian'],
            ],
            'sameAs' => array_filter([
                $this->getSetting($settings, 'facebook_url', ''),
                $this->getSetting($settings, 'instagram_url', ''),
                $this->getSetting($settings, 'twitter_url', ''),
            ]),
        ];
    }

    private function getSetting($settings, string $key, $default = '')
    {
        $setting = $settings->get($key);
        if (!$setting) return $default;
        
        $value = $setting->value;
        if (is_array($value)) {
            return $value[app()->getLocale()] ?? $value['en'] ?? $default;
        }
        return $value ?? $default;
    }

    private function getAmenities($settings): array
    {
        $amenities = [
            'Free WiFi',
            'Swimming Pool',
            'Spa',
            'Restaurant',
            'Bar',
            'Room Service',
            'Parking',
            'Air Conditioning',
            'Fitness Center',
            'Conference Rooms',
        ];

        return collect($amenities)->map(fn($a) => [
            '@type' => 'LocationFeatureSpecification',
            'name' => $a,
            'value' => true,
        ])->toArray();
    }
}
