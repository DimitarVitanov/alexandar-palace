<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'date_from',
        'date_to',
        'quantity',
        'notes',
    ];

    protected $casts = [
        'date_from' => 'date',
        'date_to' => 'date',
        'quantity' => 'integer',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function coversDate(string $date): bool
    {
        return $this->date_from->format('Y-m-d') <= $date
            && $this->date_to->format('Y-m-d') >= $date;
    }

    public function scopeOverlapping($query, string $from, string $to)
    {
        return $query->where('date_from', '<=', $to)->where('date_to', '>=', $from);
    }
}
