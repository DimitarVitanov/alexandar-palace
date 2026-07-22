@extends('emails.layout')

@section('content')
    @if($locale === 'mk')
        <h2 class="greeting">Нова резервација за терен</h2>
        
        <p class="message">
            Примена е нова резервација за терен од <strong>{{ $booking->name }}</strong>.
        </p>

        <div class="details-box">
            <h3>Детали за резервацијата</h3>
            <div class="details-row">
                <span class="details-label">Име:</span>
                <span class="details-value">{{ $booking->name }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Е-пошта:</span>
                <span class="details-value">{{ $booking->email }}</span>
            </div>
            @if($booking->phone)
            <div class="details-row">
                <span class="details-label">Телефон:</span>
                <span class="details-value">{{ $booking->phone }}</span>
            </div>
            @endif
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
            @if($booking->message)
            <div class="details-row">
                <span class="details-label">Порака:</span>
                <span class="details-value">{{ $booking->message }}</span>
            </div>
            @endif
        </div>

        <p class="message">
            Ве молиме потврдете ја резервацијата преку админ панелот.
        </p>
    @else
        <h2 class="greeting">New Court Booking Request</h2>
        
        <p class="message">
            A new court booking has been received from <strong>{{ $booking->name }}</strong>.
        </p>

        <div class="details-box">
            <h3>Booking Details</h3>
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
            @if($booking->message)
            <div class="details-row">
                <span class="details-label">Message:</span>
                <span class="details-value">{{ $booking->message }}</span>
            </div>
            @endif
        </div>

        <p class="message">
            Please confirm this booking through the admin panel.
        </p>
    @endif
@endsection
