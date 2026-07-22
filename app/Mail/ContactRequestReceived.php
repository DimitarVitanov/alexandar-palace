<?php

namespace App\Mail;

use App\Models\ContactRequest;
use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactRequestReceived extends Mailable
{
    use Queueable, SerializesModels;

    protected ?EmailTemplate $template;
    protected string $emailLocale;
    protected array $variables;

    public function __construct(public ContactRequest $contact, ?string $locale = null)
    {
        $this->emailLocale = $locale ?? app()->getLocale();
        $this->template = EmailTemplate::findByKey('contact_auto_reply');
        $this->variables = [
            'name' => $contact->name,
            'email' => $contact->email,
            'phone' => $contact->phone ?? 'N/A',
            'message' => $contact->message,
        ];
    }

    public function envelope(): Envelope
    {
        $subject = $this->template 
            ? $this->template->renderSubject($this->variables, $this->emailLocale)
            : 'Thank You for Contacting Alexandar Palace';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.template-based',
            with: [
                'body' => $this->template 
                    ? $this->template->renderBody($this->variables, $this->emailLocale)
                    : "Dear {$this->contact->name},\n\nThank you for contacting us. We will get back to you soon.",
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
