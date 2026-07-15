<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
    ];

    protected $casts = [
        'value' => 'array',
        'label' => 'array',
    ];

    protected array $translatable = [
        'label',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        if (! $setting) {
            return $default;
        }

        $value = $setting->value;

        if (is_array($value)) {
            return $value[app()->getLocale()] ?? $value['en'] ?? $value[array_key_first($value)] ?? $default;
        }

        return $value ?? $default;
    }

    public static function set(string $key, mixed $value, array $options = []): self
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $options['type'] ?? 'text',
                'group' => $options['group'] ?? 'general',
                'label' => $options['label'] ?? [$key],
            ]
        );
    }
}
