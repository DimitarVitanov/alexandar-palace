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

    public function inventories(): HasMany
    {
        return $this->hasMany(RoomInventory::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'model')->orderBy('sort_order');
    }

    public function units(): HasMany
    {
        return $this->hasMany(RoomUnit::class);
    }

    public function activeUnits(): HasMany
    {
        return $this->hasMany(RoomUnit::class)->where('is_active', true);
    }

    /**
     * Get available room units for a date range
     */
    public function getAvailableRoomUnits(string $checkIn, string $checkOut): \Illuminate\Support\Collection
    {
        return $this->activeUnits()
            ->with(['availabilities', 'bookings' => function ($query) use ($checkIn, $checkOut) {
                $query->whereIn('status', ['pending', 'confirmed'])
                    ->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn);
            }])
            ->get()
            ->filter(function (RoomUnit $unit) use ($checkIn, $checkOut) {
                return $unit->isAvailableFor($checkIn, $checkOut);
            });
    }

    /**
     * Check if any room unit is available for the date range
     */
    public function hasAvailableUnit(string $checkIn, string $checkOut): bool
    {
        return $this->getAvailableRoomUnits($checkIn, $checkOut)->isNotEmpty();
    }

    /**
     * Get the best matching room unit for a booking.
     * Prioritizes units with shorter availability windows to preserve longer ones for bigger bookings.
     */
    public function getBestAvailableUnit(string $checkIn, string $checkOut): ?RoomUnit
    {
        $availableUnits = $this->getAvailableRoomUnits($checkIn, $checkOut);
        
        if ($availableUnits->isEmpty()) {
            return null;
        }
        
        // Sort by availability window length (shortest first)
        return $availableUnits->sortBy(function (RoomUnit $unit) use ($checkIn, $checkOut) {
            // Find the availability period that covers this booking
            $matchingAvailability = $unit->availabilities
                ->where('status', 'available')
                ->filter(function ($avail) use ($checkIn, $checkOut) {
                    $from = $avail->available_from->format('Y-m-d');
                    $to = $avail->available_to->format('Y-m-d');
                    return $from <= $checkIn && $to >= $checkOut;
                })
                ->first();
            
            if (!$matchingAvailability) {
                return PHP_INT_MAX;
            }
            
            // Calculate the length of the availability window in days
            return $matchingAvailability->available_from->diffInDays($matchingAvailability->available_to);
        })->first();
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
     * Default capacity used when no inventory period covers a date.
     */
    public function getFallbackCapacityAttribute(): int
    {
        return (int) ($this->total_units ?: ($this->quantity ?: 0));
    }

    /**
     * Capacity (number of bookable rooms of this type) for a single date.
     * Inventory periods define the capacity; the highest matching period wins.
     * When the room has no inventory periods at all, total_units is used.
     */
    public function capacityOnDate($date): int
    {
        $dateStr = Carbon::parse($date)->format('Y-m-d');

        $inventories = $this->relationLoaded('inventories')
            ? $this->inventories
            : $this->inventories()->get();

        if ($inventories->isEmpty()) {
            return $this->fallback_capacity;
        }

        $matching = $inventories->filter(fn (RoomInventory $inventory) => $inventory->coversDate($dateStr));

        return $matching->isEmpty() ? 0 : (int) $matching->max('quantity');
    }

    /**
     * Number of rooms already taken on a given night.
     */
    protected function bookedOnDate(string $date, $bookings): int
    {
        return (int) $bookings->sum(function ($booking) use ($date) {
            $start = Carbon::parse($booking->check_in)->format('Y-m-d');
            $end = Carbon::parse($booking->check_out)->format('Y-m-d');

            // A booking occupies rooms on nights from check_in up to (excluding) check_out
            return ($date >= $start && $date < $end) ? max(1, (int) $booking->rooms_count) : 0;
        });
    }

    /**
     * Get how many rooms of this type remain available across the whole stay.
     */
    public function getAvailableUnits($checkIn, $checkOut): int
    {
        $checkInDate = Carbon::parse($checkIn)->startOfDay();
        $checkOutDate = Carbon::parse($checkOut)->startOfDay();

        if ($checkOutDate->lte($checkInDate)) {
            return 0;
        }

        $bookings = $this->bookings()
            ->whereNotIn('status', ['cancelled', 'rejected', 'no_show'])
            ->where('check_in', '<', $checkOutDate)
            ->where('check_out', '>', $checkInDate)
            ->get(['check_in', 'check_out', 'rooms_count']);

        $blocked = $this->blockedDates()
            ->whereBetween('blocked_date', [$checkInDate, $checkOutDate->copy()->subDay()])
            ->get(['blocked_date', 'blocked_units'])
            ->keyBy(fn ($row) => Carbon::parse($row->blocked_date)->format('Y-m-d'));

        $minAvailable = null;

        foreach (CarbonPeriod::create($checkInDate, $checkOutDate->copy()->subDay()) as $night) {
            $dateStr = $night->format('Y-m-d');
            $capacity = $this->capacityOnDate($dateStr);
            $blockedUnits = (int) ($blocked[$dateStr]->blocked_units ?? 0);
            $available = max(0, $capacity - $blockedUnits - $this->bookedOnDate($dateStr, $bookings));

            $minAvailable = $minAvailable === null ? $available : min($minAvailable, $available);

            if ($minAvailable === 0) {
                return 0;
            }
        }

        return $minAvailable ?? 0;
    }

    /**
     * Check if the requested number of rooms is available for the entire date range.
     */
    public function isAvailable($checkIn, $checkOut, int $roomsCount = 1): bool
    {
        return $this->getAvailableUnits($checkIn, $checkOut) >= max(1, $roomsCount);
    }

    /**
     * Per-date availability used by the calendar views.
     * Returns [ 'Y-m-d' => ['capacity','booked','blocked','available','status'] ]
     * status: closed (no capacity) | full | high (>= 50% taken) | open
     */
    public function getAvailabilityCalendar($startDate, $endDate): array
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->startOfDay();

        $bookings = $this->bookings()
            ->whereNotIn('status', ['cancelled', 'rejected', 'no_show'])
            ->where('check_in', '<=', $end)
            ->where('check_out', '>=', $start)
            ->get(['check_in', 'check_out', 'rooms_count']);

        $blocked = $this->blockedDates()
            ->whereBetween('blocked_date', [$start, $end])
            ->get(['blocked_date', 'blocked_units'])
            ->keyBy(fn ($row) => Carbon::parse($row->blocked_date)->format('Y-m-d'));

        $calendar = [];

        foreach (CarbonPeriod::create($start, $end) as $date) {
            $dateStr = $date->format('Y-m-d');
            $capacity = $this->capacityOnDate($dateStr);
            $blockedUnits = (int) ($blocked[$dateStr]->blocked_units ?? 0);
            $booked = $this->bookedOnDate($dateStr, $bookings);
            $taken = min($capacity, $booked + $blockedUnits);
            $available = max(0, $capacity - $booked - $blockedUnits);

            if ($capacity === 0) {
                $status = 'closed';
            } elseif ($available === 0) {
                $status = 'full';
            } elseif ($taken / $capacity >= 0.5) {
                $status = 'high';
            } else {
                $status = 'open';
            }

            $calendar[$dateStr] = [
                'date' => $dateStr,
                'capacity' => $capacity,
                'booked' => $booked,
                'blocked' => $blockedUnits,
                'available' => $available,
                'status' => $status,
            ];
        }

        return $calendar;
    }

    /**
     * Get occupancy for each day in a date range (useful for calendar views).
     */
    public function getOccupancyByDate($startDate, $endDate): array
    {
        return collect($this->getAvailabilityCalendar($startDate, $endDate))
            ->map(fn ($day) => [
                'occupied' => $day['booked'],
                'available' => $day['available'],
                'total' => $day['capacity'],
            ])
            ->all();
    }
}
