@extends('emails.layout')

@section('content')
    @if($locale === 'mk')
        <h2 class="greeting">Почитуван/а {{ $booking->name }},</h2>
        
        <p class="message">
            Ви благодариме за вашата резервација во <span class="highlight">Александар Палас</span>. 
            Ја примивме вашата резервација и ќе ви одговориме во најкраток можен рок.
        </p>

        <p class="message">
            <span class="status-badge status-pending">Се чека потврда</span>
        </p>

        <div class="details-box">
            <h3>Детали за резервацијата</h3>
            <div class="details-row">
                <span class="details-label">Тип на терен:</span>
                <span class="details-value">
                    @switch($booking->court_type)
                        @case('tennis') Тенис терен @break
                        @case('basketball') Кошаркарски терен @break
                        @case('football') Фудбалско игралиште @break
                    @endswitch
                </span>
            </div>
            <div class="details-row">
                <span class="details-label">Датум:</span>
                <span class="details-value">{{ $booking->booking_date->format('d.m.Y') }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Време:</span>
                <span class="details-value">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Број на играчи:</span>
                <span class="details-value">{{ $booking->players }}</span>
            </div>
        </div>

        <div class="divider"></div>

        <p class="message">
            Ќе ве контактираме наскоро за да ја потврдиме вашата резервација.
        </p>

        <p class="message">
            <em>Со почит,</em><br>
            <strong>Тимот на Александар Палас</strong>
        </p>
    @else
        <h2 class="greeting">Dear {{ $booking->name }},</h2>
        
        <p class="message">
            Thank you for your booking request at <span class="highlight">Aleksandar Palace</span>. 
            We have received your reservation and will get back to you as soon as possible.
        </p>

        <p class="message">
            <span class="status-badge status-pending">Pending Confirmation</span>
        </p>

        <div class="details-box">
            <h3>Booking Details</h3>
            <div class="details-row">
                <span class="details-label">Court Type:</span>
                <span class="details-value">
                    @switch($booking->court_type)
                        @case('tennis') Tennis Court @break
                        @case('basketball') Basketball Court @break
                        @case('football') Football Pitch @break
                    @endswitch
                </span>
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
        </div>

        <div class="divider"></div>

        <p class="message">
            We will contact you shortly to confirm your booking.
        </p>

        <p class="message">
            <em>Best regards,</em><br>
            <strong>The Aleksandar Palace Team</strong>
        </p>
    @endif
@endsection
