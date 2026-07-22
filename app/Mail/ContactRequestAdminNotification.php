<?php

namespace App\Mail;

use App\Models\ContactRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactRequestAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactRequest $contact)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[ADMIN] New Contact - ' . ($this->contact->subject ?? 'Website Inquiry'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-admin-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
