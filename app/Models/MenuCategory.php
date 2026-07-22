<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'banner_title',
        'banner_subtitle',
        'banner_description',
        'banner_image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'name' => 'array',
        'banner_title' => 'array',
        'banner_subtitle' => 'array',
        'banner_description' => 'array',
        'is_active' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }

    public function activeItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function getLocalizedName($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->name[$locale] ?? $this->name['en'] ?? '';
    }
}
