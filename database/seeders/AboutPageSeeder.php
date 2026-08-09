<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        // Create or get the About page
        $page = Page::firstOrCreate(
            ['slug' => 'about'],
            [
                'name' => ['en' => 'About Us', 'mk' => 'За Нас'],
                'meta_title' => ['en' => 'About Us - Alexandar Palace Hotel', 'mk' => 'За Нас - Хотел Александар Палас'],
                'meta_description' => ['en' => 'Learn about Alexandar Palace Hotel, our history, facilities, and commitment to luxury hospitality in Skopje, Macedonia.', 'mk' => 'Дознајте повеќе за Хотел Александар Палас, нашата историја, капацитети и посветеност на луксузното гостопримство во Скопје, Македонија.'],
                'is_active' => true,
            ]
        );

        // Hero Section
        PageSection::updateOrCreate(
            ['page_id' => $page->id, 'key' => 'hero'],
            [
                'title' => ['en' => 'About Alexandar Palace', 'mk' => 'За Александар Палас'],
                'subtitle' => ['en' => 'Luxury Hotel Experience', 'mk' => 'Луксузно Хотелско Искуство'],
                'image' => 'img/hero_home_1.jpg',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        // History Section
        PageSection::updateOrCreate(
            ['page_id' => $page->id, 'key' => 'history'],
            [
                'title' => ['en' => 'Our History', 'mk' => 'Нашата Историја'],
                'subtitle' => ['en' => 'Alexandar Palace Hotel', 'mk' => 'Хотел Александар Палас'],
                'content' => [
                    'en' => '<p class="lead">The hotel Aleksandar Palace, leading hotel in Macedonia, is located on the right bank of the river Vardar next to the city park, only 3 km away from the town center and just next to the most important administrative, cultural and historical buildings.</p>',
                    'mk' => '<p class="lead">Хотелот Александар Палас, водечки хотел во Македонија, се наоѓа на десниот брег на реката Вардар веднаш до градскиот парк, само 3 км од центарот на градот и во непосредна близина на најважните административни, културни и историски објекти.</p>',
                ],
                'data' => [
                    'image1' => 'img/about_1.jpg',
                    'image2' => 'img/home_1.jpg',
                ],
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        // Local Amenities Section
        PageSection::updateOrCreate(
            ['page_id' => $page->id, 'key' => 'local_amenities'],
            [
                'title' => ['en' => 'Local Amenities', 'mk' => 'Локални Погодности'],
                'subtitle' => ['en' => 'Alexandar Palace Hotel', 'mk' => 'Хотел Александар Палас'],
                'content' => [
                    'en' => 'Explore the best of Skopje - from authentic local cuisine to breathtaking nature and rich cultural heritage.',
                    'mk' => 'Истражете го најдоброто од Скопје - од автентична локална кујна до прекрасна природа и богато културно наследство.',
                ],
                'data' => [
                    'items' => [
                        [
                            'title' => 'Local Restaurants',
                            'description' => 'Discover the authentic flavors of Skopje, from traditional Macedonian taverns to modern fine dining. Enjoy local specialties such as tavče gravče, grilled meats, fresh salads, and homemade desserts in welcoming restaurants throughout the city.',
                            'links' => [
                                ['name' => 'Skopski Merak', 'url' => 'https://www.google.com/maps/dir/?api=1&destination=Restaurant%20Skopski%20Merak%2CDebarca%20St%2051%2C%201000%2C%20Skopje%201000%2C%20North%20Macedonia'],
                                ['name' => 'Pelister', 'url' => 'https://www.google.com/maps/dir/?api=1&destination=Pelister%2CBoulevard%20Macedonia%2C%20Skopje%201000%2C%20North%20Macedonia'],
                                ['name' => 'Vodenica Mulino', 'url' => 'https://www.google.com/maps/dir/?api=1&destination=Vodenica%20Mulino%2CMitropolit%20Teodosij%20Gologanov%2069%2C%20Skopje%201000%2C%20North%20Macedonia'],
                            ],
                        ],
                        [
                            'title' => 'Nature',
                            'description' => "Escape into nature just minutes from the city center. Visit the breathtaking Matka Canyon Skopje, where you can enjoy hiking, kayaking, boat tours, and spectacular limestone cliffs. For panoramic views over the city, take a walk or cable car up Mount Vodno and experience one of Skopje's most beautiful landscapes.",
                        ],
                        [
                            'title' => 'Art & Culture',
                            'description' => "Skopje blends centuries of history with contemporary creativity. Wander through the historic Old Bazaar, visit the Museum of Contemporary Art Skopje, explore Kale Fortress, and admire the city's museums, galleries, and monuments. From Ottoman architecture to modern exhibitions, Skopje offers a rich cultural experience for every visitor.",
                            'links' => [
                                ['name' => 'Museum of Contemporary Art', 'url' => 'https://www.google.com/maps/dir/?api=1&destination=Museum%20of%20Contemporary%20Art%20Skopje%2CSamoilova%2017%2C%20Skopje%201000%2C%20North%20Macedonia'],
                            ],
                        ],
                    ],
                    'images' => [
                        'img/about/restaurants.webp',
                        'img/about/nature.webp',
                        'img/about/culture.webp',
                    ],
                ],
                'sort_order' => 3,
                'is_active' => true,
            ]
        );

        // Facilities Section
        PageSection::updateOrCreate(
            ['page_id' => $page->id, 'key' => 'facilities'],
            [
                'title' => ['en' => 'Main Facilities', 'mk' => 'Главни Капацитети'],
                'subtitle' => ['en' => 'Alexandar Palace Hotel', 'mk' => 'Хотел Александар Палас'],
                'data' => [
                    'items' => [
                        ['icon' => 'customicon-private-parking', 'title' => 'Private Parking', 'description' => 'Complimentary private parking is available for all hotel guests, ensuring a convenient and secure stay.'],
                        ['icon' => 'customicon-wifi', 'title' => 'High Speed Wifi', 'description' => 'Stay connected with complimentary high-speed WiFi available throughout the hotel and in all rooms.'],
                        ['icon' => 'customicon-cocktail', 'title' => 'Bar & Restaurant', 'description' => 'Enjoy exquisite dining at our restaurant and unwind at our bar with a selection of fine wines and cocktails.'],
                        ['icon' => 'customicon-swimming-pool', 'title' => 'Swimming Pool', 'description' => 'Relax and refresh in our indoor swimming pool, perfect for a rejuvenating swim any time of year.'],
                    ],
                ],
                'sort_order' => 4,
                'is_active' => true,
            ]
        );

        // FAQ Section
        PageSection::updateOrCreate(
            ['page_id' => $page->id, 'key' => 'faq'],
            [
                'title' => ['en' => 'Frequently Questions', 'mk' => 'Често Поставувани Прашања'],
                'subtitle' => ['en' => 'Alexandar Palace Hotel Faq', 'mk' => 'ЧПП на Хотел Александар Палас'],
                'content' => [
                    'en' => "Can't find your question in the list? Let us know your questions.",
                    'mk' => 'Не можете да го најдете вашето прашање во листата? Кажете ни ги вашите прашања.',
                ],
                'data' => [
                    'items' => [
                        [
                            'question' => 'Cancellation Policy',
                            'answer' => 'Free cancellation is available up to 48 hours before check-in. Cancellations made within 48 hours of arrival may be subject to a charge equivalent to one night\'s stay. No-shows will be charged the full reservation amount.',
                        ],
                        [
                            'question' => 'Payment Methods',
                            'answer' => 'We accept all major credit cards (Visa, MasterCard, American Express), bank transfers, and cash payments. A valid credit card is required at check-in for incidentals. Full payment can be made upon arrival or departure.',
                        ],
                        [
                            'question' => 'Check In / Out Times',
                            'answer' => 'Check-in time is from 14:00 (2:00 PM). Check-out time is until 11:00 (11:00 AM). Early check-in and late check-out may be available upon request, subject to availability and additional charges.',
                        ],
                        [
                            'question' => 'Accessibility',
                            'answer' => 'Our hotel is fully accessible for guests with disabilities. We offer accessible rooms, ramps, elevators, and accessible parking spaces. Please contact us in advance to arrange any special requirements.',
                        ],
                    ],
                ],
                'sort_order' => 5,
                'is_active' => true,
            ]
        );
    }
}
