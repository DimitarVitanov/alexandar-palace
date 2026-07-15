<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tennis_courts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('name');
            $table->json('description')->nullable();
            $table->string('surface_type')->default('hard');
            $table->boolean('is_indoor')->default(false);
            $table->boolean('has_lighting')->default(true);
            $table->decimal('price_per_hour', 10, 2)->default(0);
            $table->decimal('price_per_hour_peak', 10, 2)->nullable();
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('tennis_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            $table->foreignId('tennis_court_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('players')->default(2);
            $table->boolean('equipment_rental')->default(false);
            $table->decimal('total_price', 10, 2);
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->string('payment_status')->default('unpaid');
            $table->string('payment_method')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->timestamps();
        });

        Schema::create('tennis_availability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tennis_court_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('day_of_week');
            $table->time('open_time');
            $table->time('close_time');
            $table->integer('slot_duration_minutes')->default(60);
            $table->time('peak_start_time')->nullable();
            $table->time('peak_end_time')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        Schema::create('tennis_blocked_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tennis_court_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('blocked_date');
            $table->string('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tennis_blocked_dates');
        Schema::dropIfExists('tennis_availability');
        Schema::dropIfExists('tennis_bookings');
        Schema::dropIfExists('tennis_courts');
    }
};
