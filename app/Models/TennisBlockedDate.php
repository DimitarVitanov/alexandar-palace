<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TennisBlockedDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'tennis_court_id',
        'blocked_date',
        'reason',
    ];

    protected $casts = [
        'blocked_date' => 'date',
    ];

    public function tennisCourt(): BelongsTo
    {
        return $this->belongsTo(TennisCourt::class);
    }
}
