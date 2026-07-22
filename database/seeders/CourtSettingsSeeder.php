<?php

namespace Database\Seeders;

use App\Models\CourtSetting;
use Illuminate\Database\Seeder;

class CourtSettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Default time slots (every hour from 8:00 to 21:00)
        $defaultSlots = [
            '08:00', '09:00', '10:00', '11:00', '12:00', '13:00',
            '14:00', '15:00', '16:00', '17:00', '18:00', '19:00',
            '20:00', '21:00'
        ];

        // Tennis Courts
        CourtSetting::create([
            'court_type' => 'tennis',
            'name' => 'Tennis Court A',
            'name_translations' => ['en' => 'Tennis Court A', 'mk' => 'Тенис Терен А'],
            'court_number' => 1,
            'available_slots' => $defaultSlots,
            'slot_duration' => 60,
            'price_per_slot' => 15.00,
            'max_players' => 4,
            'is_active' => true,
            'description' => 'Professional clay tennis court',
            'image' => 'img/courts/tennis-court.svg',
        ]);

        CourtSetting::create([
            'court_type' => 'tennis',
            'name' => 'Tennis Court B',
            'name_translations' => ['en' => 'Tennis Court B', 'mk' => 'Тенис Терен Б'],
            'court_number' => 2,
            'available_slots' => $defaultSlots,
            'slot_duration' => 60,
            'price_per_slot' => 15.00,
            'max_players' => 4,
            'is_active' => true,
            'description' => 'Professional clay tennis court',
            'image' => 'img/courts/tennis-court.svg',
        ]);

        // Basketball Court
        CourtSetting::create([
            'court_type' => 'basketball',
            'name' => 'Basketball Court',
            'name_translations' => ['en' => 'Basketball Court', 'mk' => 'Кошаркарски Терен'],
            'court_number' => 1,
            'available_slots' => $defaultSlots,
            'slot_duration' => 60,
            'price_per_slot' => 20.00,
            'max_players' => 10,
            'is_active' => true,
            'description' => 'Full-size outdoor basketball court',
            'image' => 'img/courts/basketball-court.svg',
        ]);

        // Football Pitch
        CourtSetting::create([
            'court_type' => 'football',
            'name' => 'Football Pitch',
            'name_translations' => ['en' => 'Football Pitch', 'mk' => 'Фудбалско Игралиште'],
            'court_number' => 1,
            'available_slots' => $defaultSlots,
            'slot_duration' => 90,
            'price_per_slot' => 50.00,
            'max_players' => 22,
            'is_active' => true,
            'description' => 'Mini football pitch with artificial turf',
            'image' => 'img/courts/football-pitch.svg',
        ]);
    }
}
