<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpaService extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'duration_minutes',
        'price',
        'discounted_price',
        'category',
        'featured_image',
        'gallery_images',
        'max_guests',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'gallery_images' => 'array',
        'price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected array $translatable = [
        'name',
        'description',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(SpaBooking::class);
    }

    public function availability(): HasMany
    {
        return $this->hasMany(SpaAvailability::class);
    }

    public function blockedDates(): HasMany
    {
        return $this->hasMany(SpaBlockedDate::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
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
            ->count();

        return $existingBookings < $availability->max_concurrent_bookings;
    }
}
