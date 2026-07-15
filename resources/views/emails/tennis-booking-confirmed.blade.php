@extends('emails.layout')

@section('content')
    <h2 class="greeting">Dear {{ $booking->name }},</h2>
    
    <p class="message">
        <strong>Your tennis court reservation is confirmed!</strong> We look forward to seeing you at 
        <span class="highlight">Alexandar Palace</span>.
    </p>

    <p class="message" style="text-align: center;">
        <span class="status-badge status-confirmed">Confirmed</span>
    </p>

    <div class="details-box">
        <h3>Confirmed Reservation</h3>
        <div class="details-row">
            <span class="details-label">Reference:</span>
            <span class="details-value highlight">{{ $booking->booking_reference }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Court:</span>
            <span class="details-value">{{ $booking->tennisCourt?->name['en'] ?? 'Tennis Court' }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Date:</span>
            <span class="details-value">{{ $booking->booking_date->format('l, F j, Y') }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Time:</span>
            <span class="details-value">{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Players:</span>
            <span class="details-value">{{ $booking->players }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Price:</span>
            <span class="details-value highlight">€{{ number_format($booking->total_price, 2) }}</span>
        </div>
    </div>

    <div class="details-box">
        <h3>Court Information</h3>
        <ul style="color: #555; padding-left: 20px; margin: 0;">
            <li style="margin-bottom: 8px;">Please arrive <strong>10 minutes</strong> before your reservation</li>
            <li style="margin-bottom: 8px;">Appropriate tennis attire and footwear required</li>
            @if($booking->equipment_rental)
            <li style="margin-bottom: 8px;">Equipment rental is included in your booking</li>
            @endif
            <li>Towels and water available at the court</li>
        </ul>
    </div>

    <div class="divider"></div>

    <p class="message">
        To cancel or reschedule, please contact us at least <strong>2 hours</strong> in advance.
    </p>

    <p class="message">
        <em>Have a great game,</em><br>
        <strong>The Alexandar Palace Team</strong>
    </p>
@endsection
