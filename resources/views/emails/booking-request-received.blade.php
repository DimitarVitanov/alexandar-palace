@extends('emails.layout')

@section('content')
    @php($isMk = $bookingLocale === 'mk')
    <h2 class="greeting">{{ $isMk ? 'Почитуван/а' : 'Dear' }} {{ $booking->name }} {{ $booking->last_name }},</h2>
    
    <p class="message">
        {{ $isMk ? 'Ви благодариме за вашето барање за резервација во' : 'Thank you for your reservation request at' }} <span class="highlight">Aleksandar Palace</span>. {{ $isMk ? 'Нашиот тим за резервации ќе го разгледа вашето барање.' : 'We have received your booking and our reservations team is reviewing it.' }}
    </p>

    <p class="message">
        <span class="status-badge status-pending">{{ $isMk ? 'Во очекување на потврда' : 'Pending Confirmation' }}</span>
    </p>

    <div class="details-box">
        <h3>{{ $isMk ? 'Детали за резервацијата' : 'Reservation Details' }}</h3>
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
            <span class="details-value">{{ $booking->check_in->format('l, F j, Y') }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">{{ $isMk ? 'Одјавување:' : 'Check-out:' }}</span>
            <span class="details-value">{{ $booking->check_out->format('l, F j, Y') }}</span>
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

    @if($booking->special_requests)
    <div class="details-box">
        <h3>{{ $isMk ? 'Посебни барања' : 'Special Requests' }}</h3>
        <p style="color: #333;">{{ $booking->special_requests }}</p>
    </div>
    @endif

    <div class="divider"></div>

    <p class="message">
        {{ $isMk ? 'Ќе добиете е-пошта штом вашата резервација биде потврдена. За сите прашања, слободно контактирајте нè.' : "You will receive a confirmation email once your reservation has been approved. If you have any questions, please don't hesitate to contact us." }}
    </p>

    <p class="message">
        <em>{{ $isMk ? 'Со задоволство ве очекуваме,' : 'We look forward to welcoming you,' }}</em><br>
        <strong>{{ $isMk ? 'Тимот на Александар Палас' : 'The Alexandar Palace Team' }}</strong>
    </p>
@endsection
