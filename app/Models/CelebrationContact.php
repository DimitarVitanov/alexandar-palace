<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CelebrationContact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'event_date',
        'guests',
        'event_type',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'event_date' => 'date',
        'guests' => 'integer',
    ];
}
