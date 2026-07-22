<?php

namespace App\Mail;

use App\Models\CelebrationContact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CelebrationContactReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public CelebrationContact $contact
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Celebration Inquiry: ' . ($this->contact->event_type ?? 'Event'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.celebration-contact-received',
        );
    }
}
