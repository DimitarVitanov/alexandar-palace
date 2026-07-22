@extends('emails.layout')

@section('content')
    <h2 class="greeting">Dear {{ $contact->name }},</h2>
    
    <p class="message">
        Thank you for reaching out to <span class="highlight">Aleksandar Palace</span>. 
        We have received your message and our dedicated team will review it promptly.
    </p>

    <p class="message">
        We strive to respond to all inquiries within <strong>24 hours</strong>. 
        In the meantime, if your matter is urgent, please don't hesitate to call us directly.
    </p>

    <div class="details-box">
        <h3>Your Message Details</h3>
        <div class="details-row">
            <span class="details-label">Subject:</span>
            <span class="details-value">{{ $contact->subject ?? 'General Inquiry' }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Submitted:</span>
            <span class="details-value">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</span>
        </div>
        <div class="details-row">
            <span class="details-label">Reference:</span>
            <span class="details-value">#CNT-{{ str_pad($contact->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
    </div>

    <div class="divider"></div>

    <p class="message">
        We look forward to assisting you and hope to welcome you to our hotel soon.
    </p>

    <p class="message">
        <em>Warm regards,</em><br>
        <strong>The Alexandar Palace Team</strong>
    </p>
@endsection
