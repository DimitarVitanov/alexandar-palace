<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'file_name',
        'original_name',
        'mime_type',
        'path',
        'size',
        'custom_properties',
        'sort_order',
    ];

    protected $casts = [
        'custom_properties' => 'array',
        'size' => 'integer',
    ];

    public function model()
    {
        return $this->morphTo();
    }

    public function url(): string
    {
        return asset('storage/'.$this->path);
    }
}
