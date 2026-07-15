<?php

namespace App\Traits;

trait Translatable
{
    public function getTranslation(string $attribute, ?string $locale = null): mixed
    {
        $locale = $locale ?? app()->getLocale();
        $value = $this->getAttributeValue($attribute);

        if (is_array($value)) {
            return $value[$locale] ?? $value['en'] ?? $value[array_key_first($value)] ?? null;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded[$locale] ?? $decoded['en'] ?? $decoded[array_key_first($decoded)] ?? null;
            }
        }

        return $value;
    }

    public function getAttribute($key)
    {
        if (in_array($key, $this->translatable ?? [])) {
            return $this->getTranslation($key);
        }

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->translatable ?? []) && is_array($value)) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE);
        }

        return parent::setAttribute($key, $value);
    }

    public function toArray()
    {
        $array = parent::toArray();

        if (! $this->shouldLocalizeArray()) {
            return $array;
        }

        foreach ($array as $key => $value) {
            $array[$key] = $this->localizeArrayValue($value);
        }

        return $array;
    }

    protected function shouldLocalizeArray(): bool
    {
        if (! function_exists('request')) {
            return true;
        }

        $request = request();

        if (! $request) {
            return true;
        }

        // Admin edit forms need the raw translation arrays to populate inputs.
        return ! $request->routeIs('admin.*.edit');
    }

    protected function localizeArrayValue(mixed $value): mixed
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);

            if (is_array($decoded) && $this->isTranslationMap($decoded)) {
                return $this->resolveTranslationMap($decoded);
            }

            return $value;
        }

        if (is_array($value)) {
            if ($this->isTranslationMap($value)) {
                return $this->resolveTranslationMap($value);
            }

            return array_map(fn ($item) => $this->localizeArrayValue($item), $value);
        }

        return $value;
    }

    protected function isTranslationMap(array $value): bool
    {
        if ($value === []) {
            return false;
        }

        $validLocales = ['en', 'mk'];

        foreach ($value as $key => $item) {
            if (! is_string($key) || ! in_array(strtolower($key), $validLocales, true)) {
                return false;
            }

            if (! is_string($item) && ! is_null($item)) {
                return false;
            }
        }

        return true;
    }

    protected function resolveTranslationMap(array $value): ?string
    {
        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');

        return $value[$locale]
            ?? $value[$fallback]
            ?? $value[array_key_first($value)]
            ?? null;
    }
}
