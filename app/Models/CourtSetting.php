<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourtSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'court_type',
        'name',
        'name_translations',
        'court_number',
        'available_slots',
        'slot_duration',
        'price_per_slot',
        'max_players',
        'is_active',
        'description',
        'image',
        'blocked_dates',
    ];

    protected $casts = [
        'name_translations' => 'array',
        'available_slots' => 'array',
        'blocked_dates' => 'array',
        'is_active' => 'boolean',
        'price_per_slot' => 'decimal:2',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(TennisCourtBooking::class, 'court_number', 'court_number')
            ->where('court_type', $this->court_type);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('court_type', $type);
    }

    public function getDisplayNameAttribute(): string
    {
        if ($this->name) {
            return $this->name;
        }
        
        $typeLabel = match($this->court_type) {
            'tennis' => 'Tennis Court',
            'basketball' => 'Basketball Court',
            'football' => 'Football Pitch',
            default => ucfirst($this->court_type),
        };
        
        return "{$typeLabel} #{$this->court_number}";
    }

    public function getAvailableSlotsForDate($date): array
    {
        $slots = $this->available_slots ?? [];
        
        // Check if date is blocked
        if ($this->blocked_dates && in_array($date, $this->blocked_dates)) {
            return [];
        }
        
        // Get booked slots for this date
        $bookedSlots = TennisCourtBooking::where('court_type', $this->court_type)
            ->where('court_number', $this->court_number)
            ->where('booking_date', $date)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->pluck('start_time')
            ->map(fn($time) => substr($time, 0, 5))
            ->toArray();
        
        return array_values(array_diff($slots, $bookedSlots));
    }
}
