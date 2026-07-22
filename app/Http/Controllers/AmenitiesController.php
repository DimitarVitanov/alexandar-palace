<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class AmenitiesController extends Controller
{
    public function index()
    {
        $amenities = [
            'accommodation' => [
                'title' => 'Accommodation',
                'icon' => 'bi-building',
                'items' => [
                    ['name' => 'Luxury Rooms & Suites', 'icon' => 'bi-door-open'],
                    ['name' => '24/7 Room Service', 'icon' => 'bi-clock'],
                    ['name' => 'Premium Bedding', 'icon' => 'bi-moon-stars'],
                    ['name' => 'Mini Bar', 'icon' => 'bi-cup-straw'],
                    ['name' => 'Safe Deposit Box', 'icon' => 'bi-safe'],
                    ['name' => 'Air Conditioning', 'icon' => 'bi-snow'],
                ],
            ],
            'dining' => [
                'title' => 'Dining & Bars',
                'icon' => 'bi-cup-hot',
                'items' => [
                    ['name' => 'Gourmet Restaurant', 'icon' => 'bi-egg-fried'],
                    ['name' => 'Tennis Restaurant', 'icon' => 'bi-shop'],
                    ['name' => 'Pool Bar', 'icon' => 'bi-cup-straw'],
                    ['name' => 'Lobby Lounge', 'icon' => 'bi-cup-hot'],
                    ['name' => 'Room Service', 'icon' => 'bi-bell'],
                    ['name' => 'Breakfast Buffet', 'icon' => 'bi-sunrise'],
                ],
            ],
            'wellness' => [
                'title' => 'Wellness & SPA',
                'icon' => 'bi-droplet-half',
                'items' => [
                    ['name' => 'Indoor Swimming Pool', 'icon' => 'bi-water'],
                    ['name' => 'Outdoor Pool', 'icon' => 'bi-sun'],
                    ['name' => 'Hammam & Sauna', 'icon' => 'bi-thermometer-sun'],
                    ['name' => 'Massage Treatments', 'icon' => 'bi-hand-index-thumb'],
                    ['name' => 'Facial & Body Care', 'icon' => 'bi-flower1'],
                    ['name' => 'Relaxation Lounge', 'icon' => 'bi-peace'],
                ],
            ],
            'sport' => [
                'title' => 'Sport & Recreation',
                'icon' => 'bi-dribbble',
                'items' => [
                    ['name' => '4 Tennis Courts', 'icon' => 'bi-circle'],
                    ['name' => '2 Basketball Courts', 'icon' => 'bi-circle'],
                    ['name' => 'Football Pitch', 'icon' => 'bi-circle'],
                    ['name' => 'Fitness Center', 'icon' => 'bi-heart-pulse'],
                    ['name' => 'Personal Trainer', 'icon' => 'bi-person-badge'],
                    ['name' => 'Equipment Rental', 'icon' => 'bi-bag-check'],
                ],
            ],
            'events' => [
                'title' => 'Events & Meetings',
                'icon' => 'bi-calendar-event',
                'items' => [
                    ['name' => 'Congress Center', 'icon' => 'bi-mic'],
                    ['name' => 'Conference Rooms', 'icon' => 'bi-display'],
                    ['name' => 'Wedding Venue', 'icon' => 'bi-heart'],
                    ['name' => 'Celebration Hall', 'icon' => 'bi-stars'],
                    ['name' => 'AV Equipment', 'icon' => 'bi-projector'],
                    ['name' => 'Catering Services', 'icon' => 'bi-basket'],
                ],
            ],
            'services' => [
                'title' => 'Guest Services',
                'icon' => 'bi-person-check',
                'items' => [
                    ['name' => 'Concierge Service', 'icon' => 'bi-info-circle'],
                    ['name' => 'Free WiFi', 'icon' => 'bi-wifi'],
                    ['name' => 'Free Parking', 'icon' => 'bi-p-circle'],
                    ['name' => 'Airport Transfer', 'icon' => 'bi-car-front'],
                    ['name' => 'Laundry Service', 'icon' => 'bi-basket3'],
                    ['name' => 'Currency Exchange', 'icon' => 'bi-currency-exchange'],
                ],
            ],
        ];

        $contact = [
            'phone' => '+389 2 3092 392',
            'email' => 'info@alexandarpalace.com.mk',
            'address' => 'Bul. Ilinden 101, 1000 Skopje, North Macedonia',
            'website' => 'www.alexandarpalace.com.mk',
        ];

        return Inertia::render('Amenities', [
            'amenities' => $amenities,
            'contact' => $contact,
            'seo' => [
                'title' => 'Hotel Amenities | Alexandar Palace',
                'description' => 'Discover all the luxury amenities and services at Alexandar Palace Hotel - SPA, fitness, restaurants, conference facilities and more.',
            ],
        ]);
    }

    public function qrCode()
    {
        return Inertia::render('AmenitiesQR', [
            'amenitiesUrl' => route('amenities'),
            'seo' => [
                'title' => 'Scan for Amenities | Alexandar Palace',
            ],
        ]);
    }
}
