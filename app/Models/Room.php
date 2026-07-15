<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Room extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'short_description',
        'amenities',
        'price_per_night',
        'discounted_price',
        'max_guests',
        'bedrooms',
        'bathrooms',
        'square_meters',
        'featured_image',
        'gallery_images',
        'is_active',
        'is_featured',
        'sort_order',
        'total_units',
        'floor',
        'view_type',
        'bed_type',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'short_description' => 'array',
        'amenities' => 'array',
        'gallery_images' => 'array',
        'price_per_night' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'meta_title' => 'array',
        'meta_description' => 'array',
    ];

    protected array $translatable = [
        'name',
        'description',
        'short_description',
        'meta_title',
        'meta_description',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function blockedDates(): HasMany
    {
        return $this->hasMany(RoomBlockedDate::class);
    }

    public function pricing(): HasMany
    {
        return $this->hasMany(RoomPricing::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'model')->orderBy('sort_order');
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

    public function getAvailableUnits($checkIn, $checkOut): int
    {
        $bookedUnits = $this->bookings()
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out', [$checkIn, $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in', '<=', $checkIn)
                          ->where('check_out', '>=', $checkOut);
                    });
            })
            ->count();

        return max(0, $this->total_units - $bookedUnits);
    }

    public function isAvailable($checkIn, $checkOut): bool
    {
        return $this->getAvailableUnits($checkIn, $checkOut) > 0;
    }
}
