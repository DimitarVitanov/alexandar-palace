<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TennisCourt extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'surface_type',
        'is_indoor',
        'has_lighting',
        'price_per_hour',
        'price_per_hour_peak',
        'featured_image',
        'gallery_images',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'gallery_images' => 'array',
        'is_indoor' => 'boolean',
        'has_lighting' => 'boolean',
        'price_per_hour' => 'decimal:2',
        'price_per_hour_peak' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected array $translatable = [
        'name',
        'description',
    ];

    public const SURFACE_HARD = 'hard';
    public const SURFACE_CLAY = 'clay';
    public const SURFACE_GRASS = 'grass';
    public const SURFACE_CARPET = 'carpet';

    public function bookings(): HasMany
    {
        return $this->hasMany(TennisBooking::class);
    }

    public function availability(): HasMany
    {
        return $this->hasMany(TennisAvailability::class);
    }

    public function blockedDates(): HasMany
    {
        return $this->hasMany(TennisBlockedDate::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isAvailable($date, $startTime, $endTime): bool
    {
        $dayOfWeek = date('w', strtotime($date));
        
        $availability = $this->availability()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->where('open_time', '<=', $startTime)
            ->where('close_time', '>=', $endTime)
            ->first();

        if (!$availability) {
            return false;
        }

        $isBlocked = $this->blockedDates()
            ->where('blocked_date', $date)
            ->exists();

        if ($isBlocked) {
            return false;
        }

        $existingBookings = $this->bookings()
            ->where('booking_date', $date)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                          ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();

        return !$existingBookings;
    }

    public function getPriceForTime($time): float
    {
        $dayOfWeek = date('w');
        $availability = $this->availability()
            ->where('day_of_week', $dayOfWeek)
            ->first();

        if ($availability && $availability->peak_start_time && $availability->peak_end_time) {
            if ($time >= $availability->peak_start_time && $time <= $availability->peak_end_time) {
                return (float) ($this->price_per_hour_peak ?? $this->price_per_hour);
            }
        }

        return (float) $this->price_per_hour;
    }
}
