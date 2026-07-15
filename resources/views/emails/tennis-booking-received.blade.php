@extends('emails.layout')

@section('content')
    <h2 class="greeting">Dear {{ $booking->name }},</h2>
    
    <p class="message">
        Thank you for booking a tennis court at <span class="highlight">Alexandar Palace</span>. 
        We have received your reservation and will confirm it shortly.
    </p>

    <p class="message">
        <span class="status-badge status-pending">Pending Confirmation</span>
    </p>

    <div class="details-box">
        <h3>Court Reservation Details</h3>
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
        @if($booking->equipment_rental)
        <div class="details-row">
            <span class="details-label">Equipment:</span>
            <span class="details-value">Rental included</span>
        </div>
        @endif
        <div class="details-row">
            <span class="details-label">Price:</span>
            <span class="details-value highlight">€{{ number_format($booking->total_price, 2) }}</span>
        </div>
    </div>

    <div class="divider"></div>

    <p class="message">
        Please arrive <strong>10 minutes</strong> before your reservation time. 
        Appropriate tennis attire and footwear are required.
    </p>

    <p class="message">
        <em>See you on the court,</em><br>
        <strong>The Alexandar Palace Team</strong>
    </p>
@endsection
