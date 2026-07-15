<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spa_services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('name');
            $table->json('description')->nullable();
            $table->integer('duration_minutes')->default(60);
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('discounted_price', 10, 2)->nullable();
            $table->string('category')->default('massage');
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->integer('max_guests')->default(1);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('spa_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            $table->foreignId('spa_service_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('guests')->default(1);
            $table->decimal('total_price', 10, 2);
            $table->text('notes')->nullable();
            $table->text('special_requests')->nullable();
            $table->string('status')->default('pending');
            $table->string('payment_status')->default('unpaid');
            $table->string('payment_method')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->timestamps();
        });

        Schema::create('spa_availability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spa_service_id')->constrained()->cascadeOnDelete();
            $table->tinyInteger('day_of_week');
            $table->time('open_time');
            $table->time('close_time');
            $table->integer('slot_duration_minutes')->default(60);
            $table->integer('max_concurrent_bookings')->default(1);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        Schema::create('spa_blocked_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spa_service_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('blocked_date');
            $table->string('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spa_blocked_dates');
        Schema::dropIfExists('spa_availability');
        Schema::dropIfExists('spa_bookings');
        Schema::dropIfExists('spa_services');
    }
};
