<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use HasFactory;
    use Translatable;

    protected $table = 'gallery_items';

    protected $fillable = [
        'category',
        'image',
        'title',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'is_active' => 'boolean',
    ];

    protected array $translatable = [
        'title',
        'description',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
