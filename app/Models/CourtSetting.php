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
        'price_options',
        'capacity',
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
        'price_options' => 'array',
        'capacity' => 'integer',
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

    public function getAvailableSlotsForDate($date, int $units = 1): array
    {
        $slots = $this->available_slots ?? [];
        
        // Check if date is blocked
        if ($this->blocked_dates && in_array($date, $this->blocked_dates)) {
            return [];
        }

        $duration = $this->slot_duration ?: 60;
        
        return array_values(array_filter($slots, function ($slot) use ($date, $units, $duration) {
            $start = self::toMinutes($slot);

            return $this->isRangeAvailable($date, $start, $start + $duration, $units);
        }));
    }

    /**
     * Whether $units of this court are free for the whole [start, end) range (minutes from midnight).
     */
    public function isRangeAvailable($date, int $start, int $end, int $units = 1): bool
    {
        $bookings = TennisCourtBooking::where('court_type', $this->court_type)
            ->where('court_number', $this->court_number)
            ->whereDate('booking_date', $date)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->get(['start_time', 'end_time', 'units'])
            ->map(fn ($b) => [self::toMinutes($b->start_time), self::toMinutes($b->end_time), $b->units ?: 1]);

        $capacity = max(1, (int) $this->capacity);
        $step = $this->slot_duration ?: 60;

        for ($from = $start; $from < $end; $from += $step) {
            $to = min($from + $step, $end);
            $used = $bookings->filter(fn ($b) => $b[0] < $to && $b[1] > $from)->sum(fn ($b) => $b[2]);

            if ($used + $units > $capacity) {
                return false;
            }
        }

        return true;
    }

    public function getPriceOption(?string $key = null): ?array
    {
        $options = $this->price_options ?: [];

        if (!$options) {
            return $this->price_per_slot === null ? null : [
                'key' => 'standard',
                'units' => 1,
                'bands' => [['until' => null, 'price' => (float) $this->price_per_slot]],
            ];
        }

        return collect($options)->firstWhere('key', $key) ?? ($key === null ? $options[0] : null);
    }

    /**
     * Price for a booking from $start to $end ("H:i"). Rates are per hour and change at each band's
     * "until" time, so a booking that crosses a boundary is charged per band (e.g. 14:00-16:00 with
     * 400 until 15:00 and 500 until 19:00 = 400 + 500).
     *
     * @return array{total: float, lines: array<int, array{from: string, to: string, rate: float, amount: float}>}|null
     */
    public function calculatePrice(string $start, string $end, ?string $optionKey = null): ?array
    {
        $option = $this->getPriceOption($optionKey);
        $from = self::toMinutes($start);
        $to = self::toMinutes($end);

        if (!$option || $to <= $from) {
            return null;
        }

        $lines = [];
        $total = 0;

        foreach ($option['bands'] as $band) {
            $bandEnd = empty($band['until']) ? 24 * 60 : self::toMinutes($band['until']);
            $segmentEnd = min($to, $bandEnd);

            if ($segmentEnd > $from) {
                $amount = round(($segmentEnd - $from) / 60 * $band['price'], 2);
                $lines[] = [
                    'from' => self::toTime($from),
                    'to' => self::toTime($segmentEnd),
                    'rate' => (float) $band['price'],
                    'amount' => $amount,
                ];
                $total += $amount;
                $from = $segmentEnd;
            }

            if ($from >= $to) {
                break;
            }
        }

        return ['total' => round($total, 2), 'lines' => $lines];
    }

    public static function toMinutes(string $time): int
    {
        [$hours, $minutes] = array_map('intval', explode(':', $time));

        return $hours * 60 + $minutes;
    }

    public static function toTime(int $minutes): string
    {
        return sprintf('%02d:%02d', intdiv($minutes, 60), $minutes % 60);
    }
}
