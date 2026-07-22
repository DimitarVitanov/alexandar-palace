<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterWelcome extends Mailable
{
    use Queueable, SerializesModels;

    public string $subscriberEmail;
    public string $userLocale;

    public function __construct(string $email, string $locale = 'en')
    {
        $this->subscriberEmail = $email;
        $this->userLocale = $locale;
    }

    public function envelope(): Envelope
    {
        $subject = $this->userLocale === 'mk' 
            ? 'Добредојдовте во нашиот билтен - Александар Палас'
            : 'Welcome to Our Newsletter - Alexandar Palace';

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter-welcome',
            with: [
                'email' => $this->subscriberEmail,
                'locale' => $this->userLocale,
            ],
        );
    }
}
