<?php

namespace App\Mail;

use App\Models\CongressContact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CongressContactReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public CongressContact $contact
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[ADMIN] Congress Center Inquiry - ' . $this->contact->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.congress-contact-received',
        );
    }
}
