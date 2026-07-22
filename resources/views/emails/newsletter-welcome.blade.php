@extends('emails.layout')

@section('content')
    @if($locale === 'mk')
        <h2 class="greeting">Добредојдовте!</h2>
        
        <p class="message">
            Ви благодариме што се претплативте на нашиот билтен на <span class="highlight">Александар Палас</span>.
        </p>

        <p class="message">
            Сега ќе бидете меѓу првите што ќе дознаат за:
        </p>

        <div class="details-box">
            <div class="details-row">
                <span class="details-value">✓ Ексклузивни понуди и попусти</span>
            </div>
            <div class="details-row">
                <span class="details-value">✓ Специјални пакети за престој</span>
            </div>
            <div class="details-row">
                <span class="details-value">✓ Настани и новости од хотелот</span>
            </div>
            <div class="details-row">
                <span class="details-value">✓ Сезонски промоции</span>
            </div>
        </div>

        <div class="divider"></div>

        <p class="message">
            Со почит,<br>
            <strong>Тимот на Александар Палас</strong>
        </p>

        <p style="font-size: 11px; color: #999; margin-top: 30px; text-align: center;">
            Ако не сакате повеќе да примате е-пошта од нас, можете да се 
            <a href="{{ config('app.url') }}/newsletter/unsubscribe/{{ $email }}" style="color: #999;">отпишете тука</a>.
        </p>
    @else
        <h2 class="greeting">Welcome!</h2>
        
        <p class="message">
            Thank you for subscribing to the <span class="highlight">Aleksandar Palace</span> newsletter.
        </p>

        <p class="message">
            You'll now be among the first to know about:
        </p>

        <div class="details-box">
            <div class="details-row">
                <span class="details-value">✓ Exclusive offers and discounts</span>
            </div>
            <div class="details-row">
                <span class="details-value">✓ Special accommodation packages</span>
            </div>
            <div class="details-row">
                <span class="details-value">✓ Hotel events and news</span>
            </div>
            <div class="details-row">
                <span class="details-value">✓ Seasonal promotions</span>
            </div>
        </div>

        <div class="divider"></div>

        <p class="message">
            Warm regards,<br>
            <strong>The Alexandar Palace Team</strong>
        </p>

        <p style="font-size: 11px; color: #999; margin-top: 30px; text-align: center;">
            If you no longer wish to receive emails from us, you can 
            <a href="{{ config('app.url') }}/newsletter/unsubscribe/{{ $email }}" style="color: #999;">unsubscribe here</a>.
        </p>
    @endif
@endsection
