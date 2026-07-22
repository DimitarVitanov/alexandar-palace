@extends('emails.layout')

@section('content')
    <h2 class="greeting">New Celebration Inquiry</h2>
    
    <p class="message">
        You have received a new inquiry from the <span class="highlight">Celebrations & Banquet Hall</span> page.
    </p>

    <div class="details-box">
        <h3>Contact Details</h3>
        <div class="details-row">
            <span class="details-label">Name:</span>
            <span class="details-value">{{ $contact->name }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Email:</span>
            <span class="details-value"><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></span>
        </div>
        @if($contact->phone)
        <div class="details-row">
            <span class="details-label">Phone:</span>
            <span class="details-value">{{ $contact->phone }}</span>
        </div>
        @endif
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
        <div class="details-row">
            <span class="details-label">Submitted:</span>
            <span class="details-value">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</span>
        </div>
    </div>

    <div class="details-box">
        <h3>Message</h3>
        <p style="color: #333; white-space: pre-wrap;">{{ $contact->message }}</p>
    </div>

    <div class="divider"></div>

    <p class="message">
        <a href="{{ config('app.url') }}/admin/celebration-contacts" class="cta-button">View in Admin Panel</a>
    </p>
@endsection
