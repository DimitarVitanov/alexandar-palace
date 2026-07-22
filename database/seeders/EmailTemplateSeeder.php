<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'key' => 'contact_auto_reply',
                'name' => 'Contact Form Auto-Reply',
                'subject' => [
                    'en' => 'Thank you for contacting Alexandar Palace Hotel',
                    'mk' => 'Ви благодариме што не контактиравте - Хотел Александар Палас',
                ],
                'body' => [
                    'en' => "Dear {{name}},\n\nThank you for contacting Alexandar Palace Hotel. We have received your message and will get back to you as soon as possible.\n\nYour message:\n{{message}}\n\nBest regards,\nAlexandar Palace Hotel Team\n\n---\nAlexandar Palace Hotel\nBul. Ilinden 109a, Skopje\nPhone: +389 2 3092 392\nEmail: info@aleksandarpalace.mk",
                    'mk' => "Почитуван/а {{name}},\n\nВи благодариме што го контактиравте Хотел Александар Палас. Ја примивме вашата порака и ќе ви одговориме во најкраток можен рок.\n\nВаша порака:\n{{message}}\n\nСо почит,\nТимот на Хотел Александар Палас\n\n---\nХотел Александар Палас\nБул. Илинден 109а, Скопје\nТелефон: +389 2 3092 392\nЕ-пошта: info@aleksandarpalace.mk",
                ],
                'description' => 'Automatic reply sent to users when they submit the contact form',
                'available_variables' => ['name', 'email', 'phone', 'message'],
            ],
            [
                'key' => 'contact_admin_notification',
                'name' => 'Contact Form Admin Notification',
                'subject' => [
                    'en' => 'New Contact Form Submission - {{name}}',
                    'mk' => 'Нова порака од контакт форма - {{name}}',
                ],
                'body' => [
                    'en' => "New contact form submission received:\n\nName: {{name}}\nEmail: {{email}}\nPhone: {{phone}}\n\nMessage:\n{{message}}\n\n---\nThis is an automated notification from Alexandar Palace Hotel website.",
                    'mk' => "Примена е нова порака од контакт формата:\n\nИме: {{name}}\nЕ-пошта: {{email}}\nТелефон: {{phone}}\n\nПорака:\n{{message}}\n\n---\nОва е автоматска нотификација од веб страната на Хотел Александар Палас.",
                ],
                'description' => 'Notification sent to admin when a new contact form is submitted',
                'available_variables' => ['name', 'email', 'phone', 'message'],
            ],
            [
                'key' => 'booking_confirmation',
                'name' => 'Booking Confirmation',
                'subject' => [
                    'en' => 'Booking Confirmation - Alexandar Palace Hotel',
                    'mk' => 'Потврда за резервација - Хотел Александар Палас',
                ],
                'body' => [
                    'en' => "Dear {{guest_name}},\n\nThank you for your booking at Alexandar Palace Hotel.\n\nBooking Details:\nRoom: {{room_name}}\nCheck-in: {{check_in}}\nCheck-out: {{check_out}}\nGuests: {{guests}}\nTotal: €{{total}}\n\nWe look forward to welcoming you!\n\nBest regards,\nAlexandar Palace Hotel Team",
                    'mk' => "Почитуван/а {{guest_name}},\n\nВи благодариме за резервацијата во Хотел Александар Палас.\n\nДетали за резервација:\nСоба: {{room_name}}\nПријавување: {{check_in}}\nОдјавување: {{check_out}}\nГости: {{guests}}\nВкупно: €{{total}}\n\nСе радуваме на вашето доаѓање!\n\nСо почит,\nТимот на Хотел Александар Палас",
                ],
                'description' => 'Confirmation email sent to guests after booking',
                'available_variables' => ['guest_name', 'guest_email', 'room_name', 'check_in', 'check_out', 'guests', 'total'],
            ],
            [
                'key' => 'booking_admin_notification',
                'name' => 'Booking Admin Notification',
                'subject' => [
                    'en' => 'New Booking - {{room_name}} - {{check_in}}',
                    'mk' => 'Нова резервација - {{room_name}} - {{check_in}}',
                ],
                'body' => [
                    'en' => "New booking received:\n\nGuest: {{guest_name}}\nEmail: {{guest_email}}\nPhone: {{guest_phone}}\n\nRoom: {{room_name}}\nCheck-in: {{check_in}}\nCheck-out: {{check_out}}\nGuests: {{guests}}\nTotal: €{{total}}\n\nSpecial Requests:\n{{special_requests}}",
                    'mk' => "Примена е нова резервација:\n\nГостин: {{guest_name}}\nЕ-пошта: {{guest_email}}\nТелефон: {{guest_phone}}\n\nСоба: {{room_name}}\nПријавување: {{check_in}}\nОдјавување: {{check_out}}\nГости: {{guests}}\nВкупно: €{{total}}\n\nПосебни барања:\n{{special_requests}}",
                ],
                'description' => 'Notification sent to admin when a new booking is made',
                'available_variables' => ['guest_name', 'guest_email', 'guest_phone', 'room_name', 'check_in', 'check_out', 'guests', 'total', 'special_requests'],
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate(
                ['key' => $template['key']],
                $template
            );
        }
    }
}
