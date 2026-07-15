<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RoomFactory extends Factory
{
    protected $model = \App\Models\Room::class;

    public function definition(): array
    {
        $name = [
            'en' => fake()->words(2, true),
            'mk' => fake()->words(2, true),
        ];

        return [
            'slug' => Str::slug($name['en']),
            'name' => $name,
            'description' => [
                'en' => fake()->paragraphs(3, true),
                'mk' => fake()->paragraphs(3, true),
            ],
            'short_description' => [
                'en' => fake()->sentence(),
                'mk' => fake()->sentence(),
            ],
            'amenities' => fake()->randomElements(['wifi', 'parking', 'pool', 'tv', 'ac', 'minibar'], 4),
            'price_per_night' => fake()->numberBetween(80, 500),
            'max_guests' => fake()->numberBetween(2, 6),
            'bedrooms' => fake()->numberBetween(1, 3),
            'bathrooms' => fake()->numberBetween(1, 2),
            'square_meters' => fake()->numberBetween(25, 120),
            'featured_image' => 'img/rooms/'.fake()->numberBetween(1, 8).'.jpg',
            'is_active' => true,
            'is_featured' => fake()->boolean(30),
        ];
    }
}
