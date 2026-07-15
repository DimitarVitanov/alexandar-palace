@extends('emails.layout')

@section('content')
    <h2 class="greeting">Dear {{ $booking->name }},</h2>
    
    <p class="message">
        <strong>Great news!</strong> Your reservation at <span class="highlight">Alexandar Palace Hotel</span> 
        has been confirmed. We are delighted to welcome you.
    </p>

    <p class="message" style="text-align: center;">
        <span class="status-badge status-confirmed">Confirmed</span>
    </p>

    <div class="details-box">
        <h3>Confirmed Reservation</h3>
        <div class="details-row">
            <span class="details-label">Booking Reference:</span>
            <span class="details-value highlight">{{ $booking->booking_reference }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Room Type:</span>
            <span class="details-value">{{ $booking->room?->name['en'] ?? 'Standard Room' }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Check-in:</span>
            <span class="details-value">{{ $booking->check_in->format('l, F j, Y') }} (from 14:00)</span>
        </div>
        <div class="details-row">
            <span class="details-label">Check-out:</span>
            <span class="details-value">{{ $booking->check_out->format('l, F j, Y') }} (until 11:00)</span>
        </div>
        <div class="details-row">
            <span class="details-label">Duration:</span>
            <span class="details-value">{{ $booking->check_in->diffInDays($booking->check_out) }} night(s)</span>
        </div>
        <div class="details-row">
            <span class="details-label">Guests:</span>
            <span class="details-value">{{ $booking->adults }} Adult(s){{ $booking->children ? ', ' . $booking->children . ' Child(ren)' : '' }}</span>
        </div>
        @if($booking->total_price)
        <div class="details-row">
            <span class="details-label">Total Price:</span>
            <span class="details-value highlight">€{{ number_format($booking->total_price, 2) }}</span>
        </div>
        @endif
    </div>

    <div class="details-box">
        <h3>Important Information</h3>
        <ul style="color: #555; padding-left: 20px; margin: 0;">
            <li style="margin-bottom: 8px;">Check-in time: <strong>14:00</strong> onwards</li>
            <li style="margin-bottom: 8px;">Check-out time: <strong>11:00</strong></li>
            <li style="margin-bottom: 8px;">Please bring a valid ID or passport</li>
            <li style="margin-bottom: 8px;">Free parking available for hotel guests</li>
            <li>Complimentary breakfast included</li>
        </ul>
    </div>

    <div class="divider"></div>

    <p class="message">
        If you need to modify or cancel your reservation, please contact us at least 
        <strong>48 hours</strong> before your check-in date.
    </p>

    <p class="message">
        <em>We look forward to providing you with an exceptional stay,</em><br>
        <strong>The Alexandar Palace Team</strong>
    </p>
@endsection
