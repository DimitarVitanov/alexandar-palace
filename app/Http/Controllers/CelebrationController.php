<?php

namespace App\Http\Controllers;

use App\Mail\CelebrationContactReceived;
use App\Mail\CelebrationContactConfirmation;
use App\Models\CelebrationContact;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class CelebrationController extends Controller
{
    public function index()
    {
        return Inertia::render('Celebrations', [
            'seo' => [
                'title' => 'Celebrations & Banquet Hall - Aleksandar Palace',
                'description' => 'Hotel Aleksandar Palace is a leading wedding celebrations venue with capacity up to 750 guests. Perfect for weddings, anniversaries, and special events.',
            ],
        ]);
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'event_date' => 'nullable|date',
            'guests' => 'nullable|integer|min:1|max:1000',
            'event_type' => 'nullable|string|max:100',
            'message' => 'required|string|max:5000',
        ]);

        $contact = CelebrationContact::create($validated);

        // Get recipients from settings or use default
        $recipients = Setting::where('key', 'celebration_contact_emails')->first()?->value 
            ?? 'vitanov1@yahoo.com';
        
        $emailList = array_map('trim', explode(',', $recipients));

        // Send notification to admins
        foreach ($emailList as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($email)->queue(new CelebrationContactReceived($contact));
            }
        }

        // Send confirmation to user
        $locale = app()->getLocale();
        Mail::to($contact->email)->queue(new CelebrationContactConfirmation($contact, $locale));

        $message = $locale === 'mk' 
            ? 'Ви благодариме за вашето барање! Ќе ви одговориме во најкраток можен рок.'
            : 'Thank you for your inquiry! We will get back to you as soon as possible.';

        return back()->with('success', $message);
    }
}
