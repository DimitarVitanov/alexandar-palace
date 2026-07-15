<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_image',
        'template',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'title' => 'array',
        'content' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'meta_keywords' => 'array',
        'is_active' => 'boolean',
    ];

    protected array $translatable = [
        'title',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class)->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
