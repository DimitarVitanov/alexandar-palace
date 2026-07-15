@extends('emails.layout')

@section('content')
    <h2 class="greeting">Dear {{ $booking->name }},</h2>
    
    <p class="message">
        Thank you for booking a spa treatment at <span class="highlight">Alexandar Palace Spa</span>. 
        We have received your appointment request and will confirm it shortly.
    </p>

    <p class="message">
        <span class="status-badge status-pending">Pending Confirmation</span>
    </p>

    <div class="details-box">
        <h3>Appointment Details</h3>
        <div class="details-row">
            <span class="details-label">Reference:</span>
            <span class="details-value highlight">{{ $booking->booking_reference }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Treatment:</span>
            <span class="details-value">{{ $booking->spaService?->name['en'] ?? 'Spa Treatment' }}</span>
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
            <span class="details-label">Guests:</span>
            <span class="details-value">{{ $booking->guests }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Price:</span>
            <span class="details-value highlight">€{{ number_format($booking->total_price, 2) }}</span>
        </div>
    </div>

    <div class="divider"></div>

    <p class="message">
        Please arrive <strong>15 minutes</strong> before your appointment time. 
        We recommend avoiding heavy meals before your treatment.
    </p>

    <p class="message">
        <em>We look forward to pampering you,</em><br>
        <strong>The Alexandar Palace Spa Team</strong>
    </p>
@endsection
