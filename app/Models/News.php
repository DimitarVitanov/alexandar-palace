<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    use Translatable;

    protected $table = 'news';

    protected $fillable = [
        'slug',
        'title',
        'excerpt',
        'content',
        'category',
        'featured_image',
        'published_at',
        'is_active',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'title' => 'array',
        'excerpt' => 'array',
        'content' => 'array',
        'published_at' => 'date',
        'is_active' => 'boolean',
        'meta_title' => 'array',
        'meta_description' => 'array',
    ];

    protected array $translatable = [
        'title',
        'excerpt',
        'content',
        'meta_title',
        'meta_description',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
