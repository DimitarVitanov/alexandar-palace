@extends('emails.layout')

@section('content')
    <h2 class="greeting">New Contact Request</h2>
    
    <p class="message">
        A new contact form submission has been received on the website.
    </p>

    <div class="details-box">
        <h3>Contact Details</h3>
        <div class="details-row">
            <span class="details-label">Name:</span>
            <span class="details-value">{{ $contact->name }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Email:</span>
            <span class="details-value">{{ $contact->email }}</span>
        </div>
        @if($contact->phone)
        <div class="details-row">
            <span class="details-label">Phone:</span>
            <span class="details-value">{{ $contact->phone }}</span>
        </div>
        @endif
        <div class="details-row">
            <span class="details-label">Subject:</span>
            <span class="details-value">{{ $contact->subject ?? 'General Inquiry' }}</span>
        </div>
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

    <p style="text-align: center;">
        <a href="{{ url('/admin/contacts/' . $contact->id) }}" class="cta-button">View in Admin Panel</a>
    </p>
@endsection
