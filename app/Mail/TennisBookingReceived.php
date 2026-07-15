<?php

namespace App\Mail;

use App\Models\TennisBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TennisBookingReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public TennisBooking $booking)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Tennis Court Reservation - ' . $this->booking->booking_reference,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tennis-booking-received',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
