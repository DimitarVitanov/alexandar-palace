<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'slug' => 'junior-suite',
                'name' => ['en' => 'Junior Suite', 'mk' => 'Јуниор апартман'],
                'short_description' => ['en' => 'Elegant suite with panoramic views.', 'mk' => 'Елегантен апартман со панорамски погледи.'],
                'price_per_night' => 250,
                'max_guests' => 3,
                'featured_image' => 'img/rooms/1.jpg',
                'is_featured' => true,
            ],
            [
                'slug' => 'deluxe-room',
                'name' => ['en' => 'Deluxe Room', 'mk' => 'Делукс соба'],
                'short_description' => ['en' => 'Comfortable room with modern amenities.', 'mk' => 'Удобна соба со модерни удобности.'],
                'price_per_night' => 190,
                'max_guests' => 2,
                'featured_image' => 'img/rooms/2.jpg',
                'is_featured' => true,
            ],
            [
                'slug' => 'superior-room',
                'name' => ['en' => 'Superior Room', 'mk' => 'Супериор соба'],
                'short_description' => ['en' => 'Spacious room with premium comfort.', 'mk' => 'Просторна соба со премиум удобност.'],
                'price_per_night' => 240,
                'max_guests' => 2,
                'featured_image' => 'img/rooms/3.jpg',
                'is_featured' => true,
            ],
            [
                'slug' => 'double-room',
                'name' => ['en' => 'Double Room', 'mk' => 'Двојна соба'],
                'short_description' => ['en' => 'Perfect for couples.', 'mk' => 'Идеална за парови.'],
                'price_per_night' => 150,
                'max_guests' => 2,
                'featured_image' => 'img/rooms/4.jpg',
            ],
            [
                'slug' => 'family-suite',
                'name' => ['en' => 'Family Suite', 'mk' => 'Фамилијарен апартман'],
                'short_description' => ['en' => 'Ideal for families.', 'mk' => 'Идеален за семејства.'],
                'price_per_night' => 320,
                'max_guests' => 5,
                'featured_image' => 'img/rooms/5.jpg',
            ],
            [
                'slug' => 'penthouse',
                'name' => ['en' => 'Penthouse', 'mk' => 'Пентхаус'],
                'short_description' => ['en' => 'Luxury penthouse experience.', 'mk' => 'Луксузно пентхаус искуство.'],
                'price_per_night' => 450,
                'max_guests' => 4,
                'featured_image' => 'img/rooms/6.jpg',
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room + [
                'description' => ['en' => 'Room description in English.', 'mk' => 'Опис на собата на македонски.'],
                'amenities' => ['wifi', 'parking', 'pool', 'tv', 'ac', 'minibar'],
                'bedrooms' => 1,
                'bathrooms' => 1,
                'square_meters' => 35,
                'is_active' => true,
                'sort_order' => 0,
            ]);
        }
    }
}
