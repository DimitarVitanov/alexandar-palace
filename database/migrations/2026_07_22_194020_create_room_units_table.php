<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Individual physical room units (e.g., Room A7, Room A8)
        Schema::create('room_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->string('unit_code', 20); // e.g., "A7", "B12", "101"
            $table->string('floor', 10)->nullable(); // e.g., "1", "2", "Ground"
            $table->text('notes')->nullable(); // Internal notes
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['room_id', 'unit_code']);
        });
        
        // Availability periods for each room unit
        Schema::create('room_unit_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_unit_id')->constrained()->onDelete('cascade');
            $table->date('available_from');
            $table->date('available_to');
            $table->enum('status', ['available', 'blocked', 'maintenance'])->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['room_unit_id', 'available_from', 'available_to']);
        });
        
        // Link bookings to specific room units
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('room_unit_id')->nullable()->after('room_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['room_unit_id']);
            $table->dropColumn('room_unit_id');
        });
        Schema::dropIfExists('room_unit_availabilities');
        Schema::dropIfExists('room_units');
    }
};
