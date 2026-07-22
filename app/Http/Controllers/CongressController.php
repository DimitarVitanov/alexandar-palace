<?php

namespace App\Http\Controllers;

use App\Mail\CongressContactReceived;
use App\Models\CongressContact;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class CongressController extends Controller
{
    public function index()
    {
        return Inertia::render('Congress', [
            'seo' => [
                'title' => 'Congress Center - Aleksandar Palace',
                'description' => 'Hotel Aleksandar Palace has established excellent reputation in the organization of business meetings, conferences and banquets. The congress center is one of the largest conference facilities in the country.',
            ],
        ]);
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $contact = CongressContact::create($validated);

        // Get recipients from settings or use default
        $recipients = Setting::where('key', 'congress_contact_emails')->first()?->value 
            ?? 'vitanov1@yahoo.com';
        
        $emailList = array_map('trim', explode(',', $recipients));

        foreach ($emailList as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($email)->queue(new CongressContactReceived($contact));
            }
        }

        return back()->with('success', 'Thank you for your inquiry! We will get back to you as soon as possible.');
    }
}
