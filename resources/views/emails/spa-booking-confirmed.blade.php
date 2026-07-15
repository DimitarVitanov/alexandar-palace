@extends('emails.layout')

@section('content')
    <h2 class="greeting">Dear {{ $booking->name }},</h2>
    
    <p class="message">
        <strong>Your spa appointment is confirmed!</strong> We are excited to welcome you to 
        <span class="highlight">Alexandar Palace Spa</span>.
    </p>

    <p class="message" style="text-align: center;">
        <span class="status-badge status-confirmed">Confirmed</span>
    </p>

    <div class="details-box">
        <h3>Confirmed Appointment</h3>
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
            <span class="details-label">Price:</span>
            <span class="details-value highlight">€{{ number_format($booking->total_price, 2) }}</span>
        </div>
    </div>

    <div class="details-box">
        <h3>Before Your Visit</h3>
        <ul style="color: #555; padding-left: 20px; margin: 0;">
            <li style="margin-bottom: 8px;">Please arrive <strong>15 minutes</strong> before your appointment</li>
            <li style="margin-bottom: 8px;">Avoid heavy meals 1-2 hours before treatment</li>
            <li style="margin-bottom: 8px;">Robes and slippers will be provided</li>
            <li>Enjoy our relaxation lounge before and after your treatment</li>
        </ul>
    </div>

    <div class="divider"></div>

    <p class="message">
        To cancel or reschedule, please contact us at least <strong>24 hours</strong> in advance.
    </p>

    <p class="message">
        <em>Relax, rejuvenate, and enjoy,</em><br>
        <strong>The Alexandar Palace Spa Team</strong>
    </p>
@endsection
