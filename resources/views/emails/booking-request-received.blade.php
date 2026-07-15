@extends('emails.layout')

@section('content')
    <h2 class="greeting">Dear {{ $booking->name }},</h2>
    
    <p class="message">
        Thank you for your reservation request at <span class="highlight">Alexandar Palace Hotel</span>. 
        We have received your booking and our reservations team is reviewing it.
    </p>

    <p class="message">
        <span class="status-badge status-pending">Pending Confirmation</span>
    </p>

    <div class="details-box">
        <h3>Reservation Details</h3>
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
            <span class="details-value">{{ $booking->check_in->format('l, F j, Y') }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Check-out:</span>
            <span class="details-value">{{ $booking->check_out->format('l, F j, Y') }}</span>
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

    @if($booking->special_requests)
    <div class="details-box">
        <h3>Special Requests</h3>
        <p style="color: #333;">{{ $booking->special_requests }}</p>
    </div>
    @endif

    <div class="divider"></div>

    <p class="message">
        You will receive a confirmation email once your reservation has been approved. 
        If you have any questions, please don't hesitate to contact us.
    </p>

    <p class="message">
        <em>We look forward to welcoming you,</em><br>
        <strong>The Alexandar Palace Team</strong>
    </p>
@endsection
