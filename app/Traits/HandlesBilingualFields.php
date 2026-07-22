<?php

namespace App\Traits;

trait HandlesBilingualFields
{
    /**
     * Convert model data to ensure bilingual fields are in the correct format.
     * Handles: plain strings, JSON strings, and proper arrays.
     */
    protected function prepareBilingualData($model, array $bilingualFields): array
    {
        $data = is_array($model) ? $model : $model->toArray();
        
        foreach ($bilingualFields as $field) {
            $value = $data[$field] ?? null;
            
            if (is_array($value)) {
                // Already in correct format - ensure both keys exist
                $data[$field] = [
                    'en' => $value['en'] ?? '',
                    'mk' => $value['mk'] ?? '',
                ];
            } elseif (is_string($value)) {
                // Try to decode as JSON first (double-encoded case)
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $data[$field] = [
                        'en' => $decoded['en'] ?? '',
                        'mk' => $decoded['mk'] ?? '',
                    ];
                } else {
                    // Plain string - put in English field
                    $data[$field] = ['en' => $value, 'mk' => ''];
                }
            } else {
                // Missing or invalid - set default
                $data[$field] = ['en' => '', 'mk' => ''];
            }
        }
        
        return $data;
    }
}
