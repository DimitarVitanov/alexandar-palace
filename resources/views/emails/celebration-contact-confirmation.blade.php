@extends('emails.layout')

@section('content')
    @if($userLocale === 'mk')
        <h2 class="greeting">Почитуван/а {{ $contact->name }},</h2>
        
        <p class="message">
            Ви благодариме за вашето интересирање за организирање на вашиот настан во <span class="highlight">Александар Палас</span>.
        </p>

        <p class="message">
            Го примивме вашето барање и нашиот тим ќе ви одговори во најкраток можен рок.
        </p>

        <div class="details-box">
            <h3>Детали за вашето барање</h3>
            @if($contact->event_type)
            <div class="details-row">
                <span class="details-label">Тип на настан:</span>
                <span class="details-value">{{ $contact->event_type }}</span>
            </div>
            @endif
            @if($contact->event_date)
            <div class="details-row">
                <span class="details-label">Датум на настан:</span>
                <span class="details-value">{{ $contact->event_date->format('d.m.Y') }}</span>
            </div>
            @endif
            @if($contact->guests)
            <div class="details-row">
                <span class="details-label">Број на гости:</span>
                <span class="details-value">{{ $contact->guests }}</span>
            </div>
            @endif
        </div>

        <p class="message">
            Доколку имате дополнителни прашања, слободно контактирајте нè.
        </p>

        <p class="message">
            Со почит,<br>
            <strong>Тимот на Александар Палас</strong>
        </p>
    @else
        <h2 class="greeting">Dear {{ $contact->name }},</h2>
        
        <p class="message">
            Thank you for your interest in hosting your event at <span class="highlight">Aleksandar Palace</span>.
        </p>

        <p class="message">
            We have received your inquiry and our team will get back to you as soon as possible.
        </p>

        <div class="details-box">
            <h3>Your Inquiry Details</h3>
            @if($contact->event_type)
            <div class="details-row">
                <span class="details-label">Event Type:</span>
                <span class="details-value">{{ $contact->event_type }}</span>
            </div>
            @endif
            @if($contact->event_date)
            <div class="details-row">
                <span class="details-label">Event Date:</span>
                <span class="details-value">{{ $contact->event_date->format('F j, Y') }}</span>
            </div>
            @endif
            @if($contact->guests)
            <div class="details-row">
                <span class="details-label">Number of Guests:</span>
                <span class="details-value">{{ $contact->guests }}</span>
            </div>
            @endif
        </div>

        <p class="message">
            If you have any additional questions, please don't hesitate to contact us.
        </p>

        <p class="message">
            Best regards,<br>
            <strong>The Aleksandar Palace Team</strong>
        </p>
    @endif
@endsection
