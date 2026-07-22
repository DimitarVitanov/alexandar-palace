<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('court_settings', function (Blueprint $table) {
            $table->id();
            $table->string('court_type'); // tennis, basketball, football
            $table->string('name')->nullable(); // e.g., "Tennis Court A", "Tennis Court B"
            $table->json('name_translations')->nullable();
            $table->integer('court_number')->default(1);
            $table->json('available_slots'); // ["08:00", "09:00", "10:00", ...]
            $table->integer('slot_duration')->default(60); // minutes per slot
            $table->decimal('price_per_slot', 8, 2)->nullable();
            $table->integer('max_players')->default(4);
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // court illustration
            $table->json('blocked_dates')->nullable(); // dates when court is unavailable
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('court_settings');
    }
};
