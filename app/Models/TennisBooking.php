<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class TennisBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'tennis_court_id',
        'name',
        'email',
        'phone',
        'booking_date',
        'start_time',
        'end_time',
        'players',
        'equipment_rental',
        'total_price',
        'notes',
        'status',
        'payment_status',
        'payment_method',
        'confirmed_at',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'equipment_rental' => 'boolean',
        'total_price' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_NO_SHOW = 'no_show';

    public const PAYMENT_UNPAID = 'unpaid';
    public const PAYMENT_PARTIAL = 'partial';
    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_REFUNDED = 'refunded';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_reference)) {
                $booking->booking_reference = 'TEN-' . strtoupper(Str::random(8));
            }
        });
    }

    public function tennisCourt(): BelongsTo
    {
        return $this->belongsTo(TennisCourt::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', now()->toDateString())
            ->whereIn('status', [self::STATUS_PENDING, self::STATUS_CONFIRMED]);
    }

    public function confirm(): void
    {
        $this->update([
            'status' => self::STATUS_CONFIRMED,
            'confirmed_at' => now(),
        ]);
    }

    public function cancel($reason = null): void
    {
        $this->update([
            'status' => self::STATUS_CANCELLED,
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
        ]);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_CONFIRMED => 'success',
            self::STATUS_CANCELLED => 'danger',
            self::STATUS_COMPLETED => 'info',
            self::STATUS_NO_SHOW => 'secondary',
            default => 'secondary',
        };
    }

    public function getPaymentBadgeAttribute(): string
    {
        return match($this->payment_status) {
            self::PAYMENT_UNPAID => 'danger',
            self::PAYMENT_PARTIAL => 'warning',
            self::PAYMENT_PAID => 'success',
            self::PAYMENT_REFUNDED => 'info',
            default => 'secondary',
        };
    }
}
