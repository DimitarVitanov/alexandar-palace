@extends('emails.layout')

@section('content')
    <h2 class="greeting">Dear {{ $booking->name }} {{ $booking->last_name }},</h2>

    <p class="message">
        We are sorry to let you know that we cannot confirm your reservation request at Alexandar Palace Hotel.
    </p>

    <p class="message" style="text-align: center;">
        <span class="status-badge status-cancelled">Unable to Confirm</span>
    </p>

    <div class="details-box">
        <h3>Reservation Request</h3>
        <div class="details-row">
            <span class="details-label">Reference:</span>
            <span class="details-value highlight">{{ $booking->booking_reference }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Room:</span>
            <span class="details-value">{{ $booking->room?->name['en'] ?? 'Selected room' }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Requested stay:</span>
            <span class="details-value">{{ $booking->check_in->format('F j, Y') }} – {{ $booking->check_out->format('F j, Y') }}</span>
        </div>
        @if($booking->cancellation_reason)
            <div class="details-row">
                <span class="details-label">Note:</span>
                <span class="details-value">{{ $booking->cancellation_reason }}</span>
            </div>
        @endif
    </div>

    <p class="message">
        Please contact our reservations team so we can help you choose another room or alternative dates. We would be pleased to welcome you to Alexandar Palace Hotel.
    </p>

    <p class="message">
        <em>Kind regards,</em><br>
        <strong>The Alexandar Palace Team</strong>
    </p>
@endsection
