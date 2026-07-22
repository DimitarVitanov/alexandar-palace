@extends('emails.layout')

@section('content')
    @if($locale === 'mk')
        <h2 class="greeting">Почитуван/а {{ $booking->name }},</h2>
        
        <p class="message">
            Одлични вести! Вашата резервација во <span class="highlight">Александар Палас</span> е потврдена!
        </p>

        <p class="message">
            <span class="status-badge status-confirmed">✓ Потврдено</span>
        </p>

        <div class="details-box">
            <h3>Детали за резервацијата</h3>
            <div class="details-row">
                <span class="details-label">Тип на терен:</span>
                <span class="details-value highlight">
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
            Ве молиме дојдете <strong>10 минути</strong> пред закажаното време. 
            Потребна е соодветна спортска облека и обувки.
        </p>

        <p class="message">
            <em>Се гледаме на теренот!</em><br>
            <strong>Тимот на Александар Палас</strong>
        </p>
    @else
        <h2 class="greeting">Dear {{ $booking->name }},</h2>
        
        <p class="message">
            Great news! Your booking at <span class="highlight">Aleksandar Palace</span> has been confirmed!
        </p>

        <p class="message">
            <span class="status-badge status-confirmed">✓ Confirmed</span>
        </p>

        <div class="details-box">
            <h3>Booking Details</h3>
            <div class="details-row">
                <span class="details-label">Court Type:</span>
                <span class="details-value highlight">
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
            Please arrive <strong>10 minutes</strong> before your scheduled time. 
            Appropriate sports attire and footwear are required.
        </p>

        <p class="message">
            <em>See you on the court!</em><br>
            <strong>The Aleksandar Palace Team</strong>
        </p>
    @endif
@endsection
