<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'subject',
        'body',
        'description',
        'available_variables',
        'is_active',
        'recipient_emails',
    ];

    protected $casts = [
        'subject' => 'array',
        'body' => 'array',
        'available_variables' => 'array',
        'is_active' => 'boolean',
        'recipient_emails' => 'array',
    ];

    public function getRecipientEmails(): array
    {
        return $this->recipient_emails ?? [];
    }

    public function getSubjectForLocale(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        return $this->subject[$locale] ?? $this->subject['en'] ?? '';
    }

    public function getBodyForLocale(?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        return $this->body[$locale] ?? $this->body['en'] ?? '';
    }

    public function renderBody(array $variables = [], ?string $locale = null): string
    {
        $body = $this->getBodyForLocale($locale);
        
        foreach ($variables as $key => $value) {
            $body = str_replace('{{' . $key . '}}', $value, $body);
        }
        
        return $body;
    }

    public function renderSubject(array $variables = [], ?string $locale = null): string
    {
        $subject = $this->getSubjectForLocale($locale);
        
        foreach ($variables as $key => $value) {
            $subject = str_replace('{{' . $key . '}}', $value, $subject);
        }
        
        return $subject;
    }

    public static function findByKey(string $key): ?self
    {
        return static::where('key', $key)->where('is_active', true)->first();
    }
}
