<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => ['en' => 'Alexandar Palace', 'mk' => 'Александар Палас'], 'type' => 'bilingual', 'group' => 'general', 'label' => ['en' => 'Site Name', 'mk' => 'Име на сајт']],
            ['key' => 'site_description', 'value' => ['en' => 'Luxury Hotel & Spa Experience', 'mk' => 'Луксузен хотел и спа искуство'], 'type' => 'bilingual', 'group' => 'general', 'label' => ['en' => 'Site Tagline', 'mk' => 'Слоган']],
            ['key' => 'logo', 'value' => 'img/logo.svg', 'type' => 'text', 'group' => 'general', 'label' => ['en' => 'Logo Path', 'mk' => 'Патека до лого']],
            
            // Contact Settings
            ['key' => 'address', 'value' => ['en' => 'Baker Street 567, Los Angeles 11023, California - US', 'mk' => 'Бејкер стрит 567, Лос Анџелес 11023, Калифорнија - САД'], 'type' => 'bilingual', 'group' => 'contact', 'label' => ['en' => 'Address', 'mk' => 'Адреса']],
            ['key' => 'city', 'value' => 'Skopje', 'type' => 'text', 'group' => 'contact', 'label' => ['en' => 'City', 'mk' => 'Град']],
            ['key' => 'country', 'value' => 'MK', 'type' => 'text', 'group' => 'contact', 'label' => ['en' => 'Country Code', 'mk' => 'Код на држава']],
            ['key' => 'postal_code', 'value' => '1000', 'type' => 'text', 'group' => 'contact', 'label' => ['en' => 'Postal Code', 'mk' => 'Поштенски број']],
            ['key' => 'phone', 'value' => '+389 2 123 4567', 'type' => 'text', 'group' => 'contact', 'label' => ['en' => 'Phone', 'mk' => 'Телефон']],
            ['key' => 'email', 'value' => 'info@alexandarpalace.com', 'type' => 'email', 'group' => 'contact', 'label' => ['en' => 'Email', 'mk' => 'Е-пошта']],
            ['key' => 'booking_email', 'value' => 'bookings@alexandarpalace.com', 'type' => 'email', 'group' => 'contact', 'label' => ['en' => 'Booking Email', 'mk' => 'Е-пошта за резервации']],
            ['key' => 'latitude', 'value' => '41.9981', 'type' => 'text', 'group' => 'contact', 'label' => ['en' => 'Latitude', 'mk' => 'Географска ширина']],
            ['key' => 'longitude', 'value' => '21.4254', 'type' => 'text', 'group' => 'contact', 'label' => ['en' => 'Longitude', 'mk' => 'Географска должина']],
            
            // Social Media
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/alexandarpalace', 'type' => 'url', 'group' => 'social', 'label' => ['en' => 'Facebook URL', 'mk' => 'Фејсбук URL']],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/alexandarpalace', 'type' => 'url', 'group' => 'social', 'label' => ['en' => 'Instagram URL', 'mk' => 'Инстаграм URL']],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/alexandarpalace', 'type' => 'url', 'group' => 'social', 'label' => ['en' => 'Twitter/X URL', 'mk' => 'Твитер/X URL']],
            ['key' => 'linkedin_url', 'value' => '', 'type' => 'url', 'group' => 'social', 'label' => ['en' => 'LinkedIn URL', 'mk' => 'LinkedIn URL']],
            ['key' => 'youtube_url', 'value' => '', 'type' => 'url', 'group' => 'social', 'label' => ['en' => 'YouTube URL', 'mk' => 'YouTube URL']],
            ['key' => 'tripadvisor_url', 'value' => '', 'type' => 'url', 'group' => 'social', 'label' => ['en' => 'TripAdvisor URL', 'mk' => 'TripAdvisor URL']],
            ['key' => 'whatsapp', 'value' => '+38970123456', 'type' => 'text', 'group' => 'social', 'label' => ['en' => 'WhatsApp Number', 'mk' => 'WhatsApp број']],
            
            // SEO Settings
            ['key' => 'meta_title', 'value' => ['en' => 'Alexandar Palace - Luxury Hotel & Spa in Skopje', 'mk' => 'Александар Палас - Луксузен хотел и спа во Скопје'], 'type' => 'bilingual', 'group' => 'seo', 'label' => ['en' => 'Default Meta Title', 'mk' => 'Стандарден мета наслов']],
            ['key' => 'meta_description', 'value' => ['en' => 'Experience luxury at Alexandar Palace Hotel & Spa in Skopje, Macedonia. World-class amenities, elegant rooms, fine dining, and exceptional service await you.', 'mk' => 'Доживејте луксуз во хотелот Александар Палас и спа во Скопје, Македонија. Светски удобности, елегантни соби, фина кујна и исклучителна услуга ве очекуваат.'], 'type' => 'bilingual', 'group' => 'seo', 'label' => ['en' => 'Default Meta Description', 'mk' => 'Стандардно мета описание']],
            ['key' => 'meta_keywords', 'value' => ['en' => 'luxury hotel skopje, hotel macedonia, spa hotel, 5 star hotel skopje, accommodation skopje, hotel alexandar palace', 'mk' => 'луксузен хотел скопје, хотел македонија, спа хотел, 5 ѕвезди хотел скопје, сместување скопје, хотел александар палас'], 'type' => 'bilingual', 'group' => 'seo', 'label' => ['en' => 'Default Meta Keywords', 'mk' => 'Стандардни мета клучни зборови']],
            ['key' => 'og_image', 'value' => '/assets/paradise/img/hero_home_1.jpg', 'type' => 'text', 'group' => 'seo', 'label' => ['en' => 'Default OG Image', 'mk' => 'Стандардна OG слика']],
            ['key' => 'google_site_verification', 'value' => '', 'type' => 'text', 'group' => 'seo', 'label' => ['en' => 'Google Site Verification', 'mk' => 'Google верификација']],
            ['key' => 'bing_site_verification', 'value' => '', 'type' => 'text', 'group' => 'seo', 'label' => ['en' => 'Bing Site Verification', 'mk' => 'Bing верификација']],
            
            // Hotel Info (for Schema.org)
            ['key' => 'star_rating', 'value' => '5', 'type' => 'text', 'group' => 'hotel', 'label' => ['en' => 'Star Rating', 'mk' => 'Број на ѕвезди']],
            ['key' => 'price_range', 'value' => '€€€', 'type' => 'text', 'group' => 'hotel', 'label' => ['en' => 'Price Range', 'mk' => 'Ценовен ранг']],
            ['key' => 'checkin_time', 'value' => '14:00', 'type' => 'text', 'group' => 'hotel', 'label' => ['en' => 'Check-in Time', 'mk' => 'Време за пријавување']],
            ['key' => 'checkout_time', 'value' => '11:00', 'type' => 'text', 'group' => 'hotel', 'label' => ['en' => 'Check-out Time', 'mk' => 'Време за одјавување']],
            ['key' => 'total_rooms', 'value' => '120', 'type' => 'text', 'group' => 'hotel', 'label' => ['en' => 'Total Rooms', 'mk' => 'Вкупно соби']],
            
            // Analytics & Tracking
            ['key' => 'google_analytics_id', 'value' => '', 'type' => 'text', 'group' => 'analytics', 'label' => ['en' => 'Google Analytics ID', 'mk' => 'Google Analytics ID']],
            ['key' => 'google_tag_manager_id', 'value' => '', 'type' => 'text', 'group' => 'analytics', 'label' => ['en' => 'Google Tag Manager ID', 'mk' => 'Google Tag Manager ID']],
            ['key' => 'facebook_pixel_id', 'value' => '', 'type' => 'text', 'group' => 'analytics', 'label' => ['en' => 'Facebook Pixel ID', 'mk' => 'Facebook Pixel ID']],
            
            // Notifications
            ['key' => 'admin_notification_emails', 'value' => 'admin@alexandarpalace.com', 'type' => 'textarea', 'group' => 'notifications', 'label' => ['en' => 'Admin Notification Emails', 'mk' => 'Е-пошта за известувања'], 'description' => 'Comma-separated list of email addresses that will receive notifications for new bookings and contact requests.'],
            ['key' => 'send_booking_notifications', 'value' => '1', 'type' => 'text', 'group' => 'notifications', 'label' => ['en' => 'Send Booking Notifications', 'mk' => 'Испрати известувања за резервации']],
            ['key' => 'send_contact_notifications', 'value' => '1', 'type' => 'text', 'group' => 'notifications', 'label' => ['en' => 'Send Contact Notifications', 'mk' => 'Испрати известувања за контакт']],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
