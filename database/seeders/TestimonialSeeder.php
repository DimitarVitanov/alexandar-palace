<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['name' => 'Roberta', 'location' => 'London', 'comment' => 'Mea ad postea meliore fuisset. Timeam repudiare id eum, ex paulo dictas elaboraret sed, mel cu unum nostrud.', 'date' => '2024-10-12', 'rating' => 5, 'photo' => 'img/testimonial_1.jpg'],
            ['name' => 'Marco', 'location' => 'Milan', 'comment' => 'Amazing experience, the staff was incredibly helpful and the rooms were spotless.', 'date' => '2024-11-02', 'rating' => 5, 'photo' => 'img/testimonial_1.jpg'],
            ['name' => 'Elena', 'location' => 'Berlin', 'comment' => 'We loved the restaurant and the spa. Will definitely come back next year.', 'date' => '2024-12-03', 'rating' => 4, 'photo' => 'img/testimonial_1.jpg'],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial + ['is_active' => true]);
        }
    }
}
