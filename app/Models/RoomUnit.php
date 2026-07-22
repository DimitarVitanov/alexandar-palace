<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomUnit extends Model
{
    protected $fillable = [
        'room_id',
        'unit_code',
        'floor',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(RoomUnitAvailability::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if this unit is available for the given date range
     */
    public function isAvailableFor(string $checkIn, string $checkOut): bool
    {
        $checkInDate = $checkIn;
        $checkOutDate = $checkOut;
        
        // Check if there's an availability period that covers these dates
        // Use loaded relation if available, otherwise query
        $availabilities = $this->relationLoaded('availabilities') 
            ? $this->availabilities 
            : $this->availabilities()->get();
            
        $hasAvailability = $availabilities
            ->where('status', 'available')
            ->filter(function ($avail) use ($checkInDate, $checkOutDate) {
                $from = $avail->available_from->format('Y-m-d');
                $to = $avail->available_to->format('Y-m-d');
                return $from <= $checkInDate && $to >= $checkOutDate;
            })
            ->isNotEmpty();

        if (!$hasAvailability) {
            return false;
        }

        // Check if there are any confirmed bookings that overlap
        // First check bookings directly linked to this unit
        $unitBookings = $this->relationLoaded('bookings')
            ? $this->bookings
            : $this->bookings()->whereIn('status', ['pending', 'confirmed'])->get();
        
        // Also check bookings linked to the room type (without specific unit assigned)
        // These are bookings that haven't been assigned to a specific unit yet
        $roomBookings = \App\Models\Booking::where('room_id', $this->room_id)
            ->whereNull('room_unit_id')
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('check_in', '<', $checkOutDate)
            ->where('check_out', '>', $checkInDate)
            ->get();
        
        // Merge both collections
        $allBookings = $unitBookings->merge($roomBookings);
            
        $hasConflictingBooking = $allBookings
            ->whereIn('status', ['pending', 'confirmed'])
            ->filter(function ($booking) use ($checkInDate, $checkOutDate) {
                $bookingStart = $booking->check_in;
                $bookingEnd = $booking->check_out;
                
                // Check for any overlap
                return $bookingStart < $checkOutDate && $bookingEnd > $checkInDate;
            })
            ->isNotEmpty();

        return !$hasConflictingBooking;
    }

    /**
     * Scope to get only active units
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get display name (Room Type + Unit Code)
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->room->name . ' - ' . $this->unit_code;
    }
}
