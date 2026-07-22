<?php

namespace App\Mail;

use App\Models\CelebrationContact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CelebrationContactConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public CelebrationContact $contact,
        public string $userLocale = 'en'
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->userLocale === 'mk' 
            ? 'Ви благодариме за вашето барање - Александар Палас'
            : 'Thank you for your inquiry - Aleksandar Palace';
            
        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.celebration-contact-confirmation',
        );
    }
}
