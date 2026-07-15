<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'slug' => 'travel-guide-2024',
                'title' => ['en' => 'The vacation and travel Guide for experts', 'mk' => 'Водич за одмор и патување за експерти'],
                'excerpt' => ['en' => 'Discover the best travel tips for your next luxury vacation.', 'mk' => 'Откријте ги најдобрите совети за патување за вашиот следен луксузен одмор.'],
                'category' => 'Travel',
                'featured_image' => 'img/blog-1.jpg',
                'published_at' => '2024-12-11',
            ],
            [
                'slug' => 'art-exhibition',
                'title' => ['en' => 'Yayoi Kusama: Infinity Mirror Rooms', 'mk' => 'Јајои Кусама: Соби со инфинитетни огледала'],
                'excerpt' => ['en' => 'Experience immersive art at the local gallery.', 'mk' => 'Доживејте ја имресивната уметност во локалната галерија.'],
                'category' => 'Event',
                'featured_image' => 'img/blog-3.jpg',
                'published_at' => '2024-12-24',
            ],
            [
                'slug' => 'best-local-restaurant',
                'title' => ['en' => 'Best Local Restaurant in 2024', 'mk' => 'Најдобар локален ресторан во 2024'],
                'excerpt' => ['en' => 'Explore the finest dining options near our hotel.', 'mk' => 'Истражете ги најдобрите опции за јадење во близина на нашиот хотел.'],
                'category' => 'Restaurant',
                'featured_image' => 'img/blog-2.jpg',
                'published_at' => '2024-12-21',
            ],
        ];

        foreach ($posts as $post) {
            News::create($post + [
                'content' => ['en' => '<p>Full article content in English.</p>', 'mk' => '<p>Целосна содржина на статијата на македонски.</p>'],
                'is_active' => true,
            ]);
        }
    }
}
