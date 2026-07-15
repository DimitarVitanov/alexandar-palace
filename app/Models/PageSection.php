<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'page_id',
        'key',
        'type',
        'title',
        'subtitle',
        'content',
        'data',
        'image',
        'video',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'title' => 'array',
        'subtitle' => 'array',
        'content' => 'array',
        'data' => 'array',
        'is_active' => 'boolean',
    ];

    protected array $translatable = [
        'title',
        'subtitle',
        'content',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
