<?php

namespace App\Mail;

use App\Models\TennisCourtBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TennisBookingReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public TennisCourtBooking $booking,
        public string $mailLocale = 'en'
    ) {
    }

    public function envelope(): Envelope
    {
        $subject = $this->mailLocale === 'mk' 
            ? 'Нова резервација за тенис терен - ' . $this->booking->name
            : 'New Tennis Court Booking - ' . $this->booking->name;
            
        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tennis-booking-received',
            with: ['locale' => $this->mailLocale],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
