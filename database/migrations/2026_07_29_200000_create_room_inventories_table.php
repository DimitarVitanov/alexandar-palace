<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Quantity based availability: "we have 30 single rooms available from X to Y"
        Schema::create('room_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->date('date_from');
            $table->date('date_to');
            $table->unsignedInteger('quantity')->default(1);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['room_id', 'date_from', 'date_to']);
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedInteger('rooms_count')->default(1)->after('room_id');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('rooms_count');
        });

        Schema::dropIfExists('room_inventories');
    }
};
