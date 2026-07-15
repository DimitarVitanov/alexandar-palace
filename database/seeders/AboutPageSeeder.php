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
                    'en' => '<p class="lead">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab.</p><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p><p>Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo.</p><p><em>Maria...the Owner</em></p>',
                    'mk' => '<p class="lead">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab.</p><p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p><p>Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo.</p><p><em>Марија...Сопственик</em></p>',
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
                        ['icon' => 'customicon-private-parking', 'title' => 'Private Parking', 'description' => 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.'],
                        ['icon' => 'customicon-wifi', 'title' => 'High Speed Wifi', 'description' => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium.'],
                        ['icon' => 'customicon-cocktail', 'title' => 'Bar & Restaurant', 'description' => 'Similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.'],
                        ['icon' => 'customicon-swimming-pool', 'title' => 'Swimming Pool', 'description' => 'Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus.'],
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
                            'question' => 'Cancellation',
                            'answer' => 'Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.',
                        ],
                        [
                            'question' => 'Payments',
                            'answer' => 'Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.',
                        ],
                        [
                            'question' => 'Check In / Out Rules',
                            'answer' => 'Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.',
                        ],
                        [
                            'question' => 'Disable Access',
                            'answer' => 'Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.',
                        ],
                    ],
                ],
                'sort_order' => 5,
                'is_active' => true,
            ]
        );
    }
}
