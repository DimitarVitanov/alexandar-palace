<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_blocked_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('blocked_date');
            $table->integer('blocked_units')->nullable();
            $table->string('reason')->nullable();
            $table->timestamps();
        });

        Schema::create('room_pricing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->decimal('price', 10, 2);
            $table->integer('available_units')->nullable();
            $table->integer('min_nights')->default(1);
            $table->timestamps();

            $table->unique(['room_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_pricing');
        Schema::dropIfExists('room_blocked_dates');
    }
};
