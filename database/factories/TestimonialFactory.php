<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model = \App\Models\Testimonial::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'location' => fake()->city(),
            'photo' => 'img/testimonial_'.fake()->numberBetween(1, 3).'.jpg',
            'comment' => fake()->paragraph(),
            'rating' => fake()->numberBetween(4, 5),
            'date' => fake()->dateTimeBetween('-12 months', 'now'),
            'is_active' => true,
        ];
    }
}
