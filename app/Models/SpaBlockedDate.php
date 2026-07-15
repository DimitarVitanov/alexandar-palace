<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpaBlockedDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'spa_service_id',
        'blocked_date',
        'reason',
    ];

    protected $casts = [
        'blocked_date' => 'date',
    ];

    public function spaService(): BelongsTo
    {
        return $this->belongsTo(SpaService::class);
    }
}
