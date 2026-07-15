<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SettingSeeder::class,
            PageSeeder::class,
            RoomSeeder::class,
            NewsSeeder::class,
            TestimonialSeeder::class,
            GalleryItemSeeder::class,
        ]);
    }
}
