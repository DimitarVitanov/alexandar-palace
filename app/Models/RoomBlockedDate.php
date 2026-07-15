<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomBlockedDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'blocked_date',
        'blocked_units',
        'reason',
    ];

    protected $casts = [
        'blocked_date' => 'date',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
