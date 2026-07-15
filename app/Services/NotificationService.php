<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;

class NotificationService
{
    public static function getAdminEmails(): array
    {
        $setting = Setting::where('key', 'admin_notification_emails')->first();
        
        if (!$setting || empty($setting->value)) {
            return [config('mail.from.address', 'admin@alexandarpalace.mk')];
        }
        
        $emails = is_array($setting->value) 
            ? $setting->value 
            : array_map('trim', explode(',', $setting->value));
        
        return array_filter($emails, fn($email) => filter_var($email, FILTER_VALIDATE_EMAIL));
    }
    
    public static function notifyAdmins(Mailable $mailable): void
    {
        $emails = self::getAdminEmails();
        
        foreach ($emails as $email) {
            try {
                Mail::to($email)->queue($mailable);
            } catch (\Exception $e) {
                \Log::error('Failed to send admin notification to ' . $email . ': ' . $e->getMessage());
            }
        }
    }
    
    public static function notifyGuest(string $email, Mailable $mailable): void
    {
        try {
            Mail::to($email)->queue($mailable);
        } catch (\Exception $e) {
            \Log::error('Failed to send guest notification to ' . $email . ': ' . $e->getMessage());
        }
    }
}
