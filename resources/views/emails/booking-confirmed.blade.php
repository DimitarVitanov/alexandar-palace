@extends('emails.layout')

@section('content')
    @php($isMk = $bookingLocale === 'mk')
    <h2 class="greeting">{{ $isMk ? 'Почитуван/а' : 'Dear' }} {{ $booking->name }} {{ $booking->last_name }},</h2>
    
    <p class="message">
        <strong>{{ $isMk ? 'Одлични вести!' : 'Great news!' }}</strong> {{ $isMk ? 'Вашата резервација во' : 'Your reservation at' }} <span class="highlight">Aleksandar Palace</span> {{ $isMk ? 'е потврдена. Со задоволство ве очекуваме.' : 'has been confirmed. We are delighted to welcome you.' }}
    </p>

    <p class="message" style="text-align: center;">
        <span class="status-badge status-confirmed">{{ $isMk ? 'Потврдено' : 'Confirmed' }}</span>
    </p>

    <div class="details-box">
        <h3>{{ $isMk ? 'Потврдена резервација' : 'Confirmed Reservation' }}</h3>
        <div class="details-row">
            <span class="details-label">{{ $isMk ? 'Референца:' : 'Booking Reference:' }}</span>
            <span class="details-value highlight">{{ $booking->booking_reference }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">{{ $isMk ? 'Соба:' : 'Room Type:' }}</span>
            <span class="details-value">{{ $booking->room?->getTranslation('name', $bookingLocale) ?? ($isMk ? 'Стандардна соба' : 'Standard Room') }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">{{ $isMk ? 'Пријавување:' : 'Check-in:' }}</span>
            <span class="details-value">{{ $booking->check_in->format('l, F j, Y') }} ({{ $isMk ? 'од 14:00' : 'from 14:00' }})</span>
        </div>
        <div class="details-row">
            <span class="details-label">{{ $isMk ? 'Одјавување:' : 'Check-out:' }}</span>
            <span class="details-value">{{ $booking->check_out->format('l, F j, Y') }} ({{ $isMk ? 'до 11:00' : 'until 11:00' }})</span>
        </div>
        <div class="details-row">
            <span class="details-label">{{ $isMk ? 'Престој:' : 'Duration:' }}</span>
            <span class="details-value">{{ $booking->check_in->diffInDays($booking->check_out) }} {{ $isMk ? 'ноќевања' : 'night(s)' }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">{{ $isMk ? 'Гости:' : 'Guests:' }}</span>
            <span class="details-value">{{ $booking->adults }} {{ $isMk ? 'возрасни' : 'Adult(s)' }}{{ $booking->children ? ', ' . $booking->children . ' ' . ($isMk ? 'деца' : 'Child(ren)') : '' }}</span>
        </div>
        @if($booking->total_price)
        <div class="details-row">
            <span class="details-label">{{ $isMk ? 'Вкупна цена:' : 'Total Price:' }}</span>
            <span class="details-value highlight">€{{ number_format($booking->total_price, 2) }}</span>
        </div>
        @endif
    </div>

    <div class="details-box">
        <h3>{{ $isMk ? 'Важни информации' : 'Important Information' }}</h3>
        <ul style="color: #555; padding-left: 20px; margin: 0;">
            <li style="margin-bottom: 8px;">{{ $isMk ? 'Пријавување: од' : 'Check-in time:' }} <strong>14:00</strong></li>
            <li style="margin-bottom: 8px;">{{ $isMk ? 'Одјавување: до' : 'Check-out time:' }} <strong>11:00</strong></li>
            <li style="margin-bottom: 8px;">{{ $isMk ? 'Понесете важечка лична карта или пасош' : 'Please bring a valid ID or passport' }}</li>
            <li style="margin-bottom: 8px;">{{ $isMk ? 'Бесплатен паркинг за хотелските гости' : 'Free parking available for hotel guests' }}</li>
            <li>{{ $isMk ? 'Вклучен е појадок' : 'Complimentary breakfast included' }}</li>
        </ul>
    </div>

    <div class="divider"></div>

    <p class="message">
        {{ $isMk ? 'Доколку сакате да ја измените или откажете резервацијата, контактирајте нè најмалку' : 'If you need to modify or cancel your reservation, please contact us at least' }} <strong>48 {{ $isMk ? 'часа' : 'hours' }}</strong> {{ $isMk ? 'пред датумот на пријавување.' : 'before your check-in date.' }}
    </p>

    <p class="message">
        <em>{{ $isMk ? 'Со задоволство ве очекуваме,' : 'We look forward to providing you with an exceptional stay,' }}</em><br>
        <strong>{{ $isMk ? 'Тимот на Александар Палас' : 'The Alexandar Palace Team' }}</strong>
    </p>
@endsection
