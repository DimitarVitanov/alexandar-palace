<?php

namespace App\Models;

use App\Traits\Translatable;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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
        'quantity',
        'available_quantity',
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

    /**
     * Get available units for a date range by checking each night's occupancy.
     * A guest occupies a room from check-in date until (but not including) check-out date.
     */
    public function getAvailableUnits($checkIn, $checkOut): int
    {
        $checkInDate = Carbon::parse($checkIn)->startOfDay();
        $checkOutDate = Carbon::parse($checkOut)->startOfDay();
        
        // Get all active bookings that could potentially overlap
        $bookings = $this->bookings()
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->where('check_in', '<', $checkOutDate)
            ->where('check_out', '>', $checkInDate)
            ->get(['check_in', 'check_out']);
        
        if ($bookings->isEmpty()) {
            return $this->total_units ?? 1;
        }
        
        // Check each night in the requested range
        $minAvailable = $this->total_units ?? 1;
        $period = CarbonPeriod::create($checkInDate, $checkOutDate->copy()->subDay());
        
        foreach ($period as $night) {
            $occupiedUnits = 0;
            
            foreach ($bookings as $booking) {
                $bookingStart = Carbon::parse($booking->check_in)->startOfDay();
                $bookingEnd = Carbon::parse($booking->check_out)->startOfDay();
                
                // A booking occupies the room on nights from check_in to check_out-1
                if ($night->gte($bookingStart) && $night->lt($bookingEnd)) {
                    $occupiedUnits++;
                }
            }
            
            $availableThisNight = max(0, ($this->total_units ?? 1) - $occupiedUnits);
            $minAvailable = min($minAvailable, $availableThisNight);
            
            // Early exit if no availability
            if ($minAvailable === 0) {
                return 0;
            }
        }
        
        return $minAvailable;
    }

    /**
     * Check if at least one unit is available for the entire date range.
     */
    public function isAvailable($checkIn, $checkOut): bool
    {
        return $this->getAvailableUnits($checkIn, $checkOut) > 0;
    }
    
    /**
     * Get occupancy for each day in a date range (useful for calendar views).
     */
    public function getOccupancyByDate($startDate, $endDate): array
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->startOfDay();
        
        $bookings = $this->bookings()
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->where('check_in', '<=', $end)
            ->where('check_out', '>=', $start)
            ->get(['check_in', 'check_out']);
        
        $occupancy = [];
        $period = CarbonPeriod::create($start, $end);
        
        foreach ($period as $date) {
            $dateStr = $date->format('Y-m-d');
            $occupied = 0;
            
            foreach ($bookings as $booking) {
                $bookingStart = Carbon::parse($booking->check_in)->startOfDay();
                $bookingEnd = Carbon::parse($booking->check_out)->startOfDay();
                
                if ($date->gte($bookingStart) && $date->lt($bookingEnd)) {
                    $occupied++;
                }
            }
            
            $occupancy[$dateStr] = [
                'occupied' => $occupied,
                'available' => max(0, ($this->total_units ?? 1) - $occupied),
                'total' => $this->total_units ?? 1,
            ];
        }
        
        return $occupancy;
    }
}
