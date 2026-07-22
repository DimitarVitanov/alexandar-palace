@extends('emails.layout')

@section('content')
    @php($isMk = $bookingLocale === 'mk')
    <h2 class="greeting">{{ $isMk ? 'Почитуван/а' : 'Dear' }} {{ $booking->name }} {{ $booking->last_name }},</h2>

    <p class="message">
        {{ $isMk ? 'Со жалење ве известуваме дека не можеме да го потврдиме вашето барање за резервација во Alexandar Palace Hotel.' : 'We are sorry to let you know that we cannot confirm your reservation request at Alexandar Palace Hotel.' }}
    </p>

    <p class="message" style="text-align: center;">
        <span class="status-badge status-cancelled">{{ $isMk ? 'Не може да се потврди' : 'Unable to Confirm' }}</span>
    </p>

    <div class="details-box">
        <h3>{{ $isMk ? 'Барање за резервација' : 'Reservation Request' }}</h3>
        <div class="details-row">
            <span class="details-label">{{ $isMk ? 'Референца:' : 'Reference:' }}</span>
            <span class="details-value highlight">{{ $booking->booking_reference }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">{{ $isMk ? 'Соба:' : 'Room:' }}</span>
            <span class="details-value">{{ $booking->room?->name['en'] ?? 'Selected room' }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">{{ $isMk ? 'Баран престој:' : 'Requested stay:' }}</span>
            <span class="details-value">{{ $booking->check_in->format('F j, Y') }} – {{ $booking->check_out->format('F j, Y') }}</span>
        </div>
        @if($booking->cancellation_reason)
            <div class="details-row">
                <span class="details-label">{{ $isMk ? 'Забелешка:' : 'Note:' }}</span>
                <span class="details-value">{{ $booking->cancellation_reason }}</span>
            </div>
        @endif
    </div>

    <p class="message">
        {{ $isMk ? 'Контактирајте го нашиот тим за резервации за да ви помогнеме да изберете друга соба или алтернативни датуми.' : 'Please contact our reservations team so we can help you choose another room or alternative dates. We would be pleased to welcome you to Alexandar Palace Hotel.' }}
    </p>

    <p class="message">
        <em>{{ $isMk ? 'Со почит,' : 'Kind regards,' }}</em><br>
        <strong>{{ $isMk ? 'Тимот на Александар Палас' : 'The Alexandar Palace Team' }}</strong>
    </p>
@endsection
