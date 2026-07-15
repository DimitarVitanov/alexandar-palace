@extends('emails.layout')

@section('content')
    <h2 class="greeting">New Room Booking Request</h2>
    
    <p class="message">
        A new room booking request has been submitted on the website.
    </p>

    <div class="details-box">
        <h3>Guest Information</h3>
        <div class="details-row">
            <span class="details-label">Name:</span>
            <span class="details-value">{{ $booking->name }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Email:</span>
            <span class="details-value">{{ $booking->email }}</span>
        </div>
        @if($booking->phone)
        <div class="details-row">
            <span class="details-label">Phone:</span>
            <span class="details-value">{{ $booking->phone }}</span>
        </div>
        @endif
    </div>

    <div class="details-box">
        <h3>Booking Details</h3>
        <div class="details-row">
            <span class="details-label">Reference:</span>
            <span class="details-value highlight">{{ $booking->booking_reference }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Room:</span>
            <span class="details-value">{{ $booking->room?->name['en'] ?? 'Not specified' }}</span>
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
            <span class="details-label">Nights:</span>
            <span class="details-value">{{ $booking->check_in->diffInDays($booking->check_out) }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Guests:</span>
            <span class="details-value">{{ $booking->adults }} Adults, {{ $booking->children ?? 0 }} Children</span>
        </div>
        @if($booking->total_price)
        <div class="details-row">
            <span class="details-label">Total Price:</span>
            <span class="details-value">€{{ number_format($booking->total_price, 2) }}</span>
        </div>
        @endif
    </div>

    @if($booking->special_requests || $booking->notes)
    <div class="details-box">
        <h3>Notes & Special Requests</h3>
        @if($booking->special_requests)
        <p style="color: #333; margin-bottom: 10px;"><strong>Special Requests:</strong><br>{{ $booking->special_requests }}</p>
        @endif
        @if($booking->notes)
        <p style="color: #333;"><strong>Notes:</strong><br>{{ $booking->notes }}</p>
        @endif
    </div>
    @endif

    <div class="divider"></div>

    <p style="text-align: center;">
        <a href="{{ url('/admin/bookings/' . $booking->id) }}" class="cta-button">View & Manage Booking</a>
    </p>
@endsection
