<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('court_settings', function (Blueprint $table) {
            // [{key, label: {en, mk}, units, bands: [{until: "15:00"|null, price}]}] - prices in MKD per hour
            $table->json('price_options')->nullable()->after('price_per_slot');
            // How many units can be booked at the same time (e.g. basketball court = 2 hoops)
            $table->integer('capacity')->default(1)->after('price_options');
        });

        Schema::table('tennis_court_bookings', function (Blueprint $table) {
            $table->string('price_option')->nullable()->after('court_number');
            $table->integer('units')->default(1)->after('price_option');
            $table->decimal('total_price', 10, 2)->nullable()->after('units');
        });

        $slots = [
            '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00',
            '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00',
        ];
        $flat = fn (float $price) => [['until' => null, 'price' => $price]];
        $standard = ['en' => 'Standard', 'mk' => 'Стандардно'];

        // Tennis - hard surface: until 15:00 = 400, until 19:00 = 500, after 19:00 = 600
        DB::table('court_settings')->where('court_type', 'tennis')->update([
            'price_per_slot' => 400,
            'slot_duration' => 60,
            'description' => 'Hard surface tennis court',
            'price_options' => json_encode([[
                'key' => 'standard',
                'label' => $standard,
                'units' => 1,
                'bands' => [
                    ['until' => '15:00', 'price' => 400],
                    ['until' => '19:00', 'price' => 500],
                    ['until' => null, 'price' => 600],
                ],
            ]]),
        ]);

        // Tennis - grass surface: 1.000 per hour
        DB::table('court_settings')->insert([
            'court_type' => 'tennis',
            'name' => 'Tennis Court - Grass',
            'name_translations' => json_encode(['en' => 'Tennis Court - Grass', 'mk' => 'Тенис Терен - Трева']),
            'court_number' => (int) DB::table('court_settings')->where('court_type', 'tennis')->max('court_number') + 1,
            'available_slots' => json_encode($slots),
            'slot_duration' => 60,
            'price_per_slot' => 1000,
            'price_options' => json_encode([[
                'key' => 'standard', 'label' => $standard, 'units' => 1, 'bands' => $flat(1000),
            ]]),
            'capacity' => 1,
            'max_players' => 4,
            'is_active' => true,
            'description' => 'Grass surface tennis court',
            'image' => 'img/courts/tennis-court.svg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Football pitch: 1.790 per hour
        DB::table('court_settings')->where('court_type', 'football')->update([
            'price_per_slot' => 1790,
            'slot_duration' => 60,
            'price_options' => json_encode([[
                'key' => 'standard', 'label' => $standard, 'units' => 1, 'bands' => $flat(1790),
            ]]),
        ]);

        // Basketball: 650 for one hoop, 1.300 for the full court, per hour
        DB::table('court_settings')->where('court_type', 'basketball')->update([
            'price_per_slot' => 650,
            'slot_duration' => 60,
            'capacity' => 2,
            'price_options' => json_encode([
                [
                    'key' => 'hoop',
                    'label' => ['en' => 'One hoop (half court)', 'mk' => 'Еден кош (баскет)'],
                    'units' => 1,
                    'bands' => $flat(650),
                ],
                [
                    'key' => 'full',
                    'label' => ['en' => 'Full court', 'mk' => 'Цел терен'],
                    'units' => 2,
                    'bands' => $flat(1300),
                ],
            ]),
        ]);
    }

    public function down(): void
    {
        DB::table('court_settings')->where('name', 'Tennis Court - Grass')->delete();

        Schema::table('tennis_court_bookings', function (Blueprint $table) {
            $table->dropColumn(['price_option', 'units', 'total_price']);
        });

        Schema::table('court_settings', function (Blueprint $table) {
            $table->dropColumn(['price_options', 'capacity']);
        });
    }
};
