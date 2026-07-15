<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    protected $model = \App\Models\News::class;

    public function definition(): array
    {
        $title = [
            'en' => fake()->sentence(),
            'mk' => fake()->sentence(),
        ];

        return [
            'slug' => Str::slug($title['en']),
            'title' => $title,
            'excerpt' => [
                'en' => fake()->paragraph(),
                'mk' => fake()->paragraph(),
            ],
            'content' => [
                'en' => fake()->paragraphs(5, true),
                'mk' => fake()->paragraphs(5, true),
            ],
            'category' => fake()->randomElement(['Travel', 'Event', 'Restaurant', 'Hotel']),
            'featured_image' => 'img/blog-'.fake()->numberBetween(1, 4).'.jpg',
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'is_active' => true,
        ];
    }
}
