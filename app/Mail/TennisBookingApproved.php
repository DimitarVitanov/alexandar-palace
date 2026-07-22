<?php

namespace App\Mail;

use App\Models\TennisCourtBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TennisBookingApproved extends Mailable
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
            ? 'Вашата резервација е потврдена! - Александар Палас'
            : 'Your Booking is Confirmed! - Aleksandar Palace';
            
        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tennis-booking-approved',
            with: ['locale' => $this->mailLocale],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
