<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomPricing extends Model
{
    use HasFactory;

    protected $table = 'room_pricing';

    protected $fillable = [
        'room_id',
        'date',
        'price',
        'available_units',
        'min_nights',
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
