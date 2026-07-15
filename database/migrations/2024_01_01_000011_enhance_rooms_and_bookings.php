<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add inventory to rooms
        Schema::table('rooms', function (Blueprint $table) {
            $table->integer('total_units')->default(1)->after('sort_order');
            $table->integer('floor')->nullable()->after('total_units');
            $table->string('view_type')->nullable()->after('floor');
            $table->string('bed_type')->nullable()->after('view_type');
            $table->json('gallery_images')->nullable()->after('featured_image');
        });

        // Enhance bookings table
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('booking_reference')->unique()->nullable()->after('id');
            $table->decimal('total_price', 10, 2)->nullable()->after('children');
            $table->decimal('deposit_amount', 10, 2)->nullable()->after('total_price');
            $table->string('payment_status')->default('unpaid')->after('status');
            $table->string('payment_method')->nullable()->after('payment_status');
            $table->text('special_requests')->nullable()->after('notes');
            $table->timestamp('confirmed_at')->nullable()->after('special_requests');
            $table->timestamp('cancelled_at')->nullable()->after('confirmed_at');
            $table->string('cancellation_reason')->nullable()->after('cancelled_at');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['total_units', 'floor', 'view_type', 'bed_type', 'gallery_images']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'booking_reference', 'total_price', 'deposit_amount', 
                'payment_status', 'payment_method', 'special_requests',
                'confirmed_at', 'cancelled_at', 'cancellation_reason'
            ]);
        });
    }
};
