<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomUnitAvailability extends Model
{
    protected $fillable = [
        'room_unit_id',
        'available_from',
        'available_to',
        'status',
        'notes',
    ];

    protected $casts = [
        'available_from' => 'date',
        'available_to' => 'date',
    ];

    public function roomUnit(): BelongsTo
    {
        return $this->belongsTo(RoomUnit::class);
    }

    /**
     * Scope to get available periods
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Check if this availability period covers the given date range
     */
    public function coversDateRange(string $checkIn, string $checkOut): bool
    {
        return $this->available_from <= $checkIn && $this->available_to >= $checkOut;
    }
}
