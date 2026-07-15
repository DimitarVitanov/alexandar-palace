<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpaAvailability extends Model
{
    use HasFactory;

    protected $table = 'spa_availability';

    protected $fillable = [
        'spa_service_id',
        'day_of_week',
        'open_time',
        'close_time',
        'slot_duration_minutes',
        'max_concurrent_bookings',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public const DAYS = [
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
    ];

    public function spaService(): BelongsTo
    {
        return $this->belongsTo(SpaService::class);
    }

    public function getDayNameAttribute(): string
    {
        return self::DAYS[$this->day_of_week] ?? 'Unknown';
    }
}
