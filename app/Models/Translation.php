<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Translation extends Model
{
    protected $fillable = ['group', 'key', 'locale', 'value'];

    public static function getAll(string $locale): array
    {
        return Cache::remember("translations_{$locale}", 3600, function () use ($locale) {
            $translations = self::where('locale', $locale)->get();
            
            $result = [];
            foreach ($translations as $translation) {
                if (!isset($result[$translation->group])) {
                    $result[$translation->group] = [];
                }
                $result[$translation->group][$translation->key] = $translation->value;
            }
            
            return $result;
        });
    }

    public static function clearCache(): void
    {
        Cache::forget('translations_en');
        Cache::forget('translations_mk');
    }

    protected static function booted(): void
    {
        static::saved(fn() => self::clearCache());
        static::deleted(fn() => self::clearCache());
    }
}
