<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingRequestReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking, public string $bookingLocale = 'en')
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: ($this->bookingLocale === 'mk' ? 'Вашето барање за резервација - ' : 'Your Reservation Request - ') . $this->booking->booking_reference,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-request-received',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
