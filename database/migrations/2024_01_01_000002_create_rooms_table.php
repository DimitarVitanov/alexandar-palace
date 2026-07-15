<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('name');
            $table->json('description')->nullable();
            $table->json('short_description')->nullable();
            $table->json('amenities')->nullable();
            $table->decimal('price_per_night', 10, 2)->default(0);
            $table->decimal('discounted_price', 10, 2)->nullable();
            $table->integer('max_guests')->default(2);
            $table->integer('bedrooms')->default(1);
            $table->integer('bathrooms')->default(1);
            $table->integer('square_meters')->nullable();
            $table->string('featured_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
