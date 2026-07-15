<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use Illuminate\Database\Seeder;

class GalleryItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['category' => 'Hotel', 'image' => 'img/rooms/1.jpg'],
            ['category' => 'Hotel', 'image' => 'img/rooms/2.jpg'],
            ['category' => 'Hotel', 'image' => 'img/rooms/3.jpg'],
            ['category' => 'Restaurant', 'image' => 'img/local_amenities_1.jpg'],
            ['category' => 'Restaurant', 'image' => 'img/local_amenities_3.jpg'],
            ['category' => 'Rooms', 'image' => 'img/rooms/4.jpg'],
            ['category' => 'Rooms', 'image' => 'img/rooms/5.jpg'],
            ['category' => 'Rooms', 'image' => 'img/rooms/6.jpg'],
        ];

        foreach ($items as $item) {
            GalleryItem::create($item + [
                'title' => ['en' => 'Gallery Image', 'mk' => 'Галерија слика'],
                'description' => ['en' => 'Beautiful view from Alexandar Palace.', 'mk' => 'Убав поглед од Александар Палас.'],
                'is_active' => true,
            ]);
        }
    }
}
