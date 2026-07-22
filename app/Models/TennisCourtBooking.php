<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TennisCourtBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'booking_date',
        'start_time',
        'end_time',
        'court_type',
        'court_number',
        'players',
        'message',
        'status',
        'admin_notes',
        'locale',
        'is_read',
        'confirmed_at',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'is_read' => 'boolean',
        'confirmed_at' => 'datetime',
        'players' => 'integer',
        'court_number' => 'integer',
    ];

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', now()->toDateString());
    }

    public function getCourtTypeLabelAttribute(): string
    {
        return match($this->court_type) {
            'tennis' => 'Tennis Court',
            'basketball' => 'Basketball Court',
            'football' => 'Football Pitch',
            default => $this->court_type,
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
            'completed' => 'secondary',
            default => 'secondary',
        };
    }
}
