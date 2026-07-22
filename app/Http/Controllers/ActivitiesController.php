<?php

namespace App\Http\Controllers;

use App\Mail\TennisBookingConfirmation;
use App\Mail\TennisBookingReceived;
use App\Models\CourtSetting;
use App\Models\Setting;
use App\Models\TennisCourtBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class ActivitiesController extends Controller
{
    public function index()
    {
        $courts = CourtSetting::active()->get()->groupBy('court_type');
        
        return Inertia::render('Activities', [
            'courts' => $courts,
            'seo' => [
                'title' => 'Activities - Sport & SPA | Aleksandar Palace',
                'description' => 'Tennis courts, basketball courts, football pitch, premium fitness center, and spa services at Aleksandar Palace.',
            ],
        ]);
    }
    
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'court_type' => 'required|string',
            'court_number' => 'required|integer',
            'date' => 'required|date',
        ]);
        
        $court = CourtSetting::where('court_type', $request->court_type)
            ->where('court_number', $request->court_number)
            ->first();
        
        if (!$court) {
            return response()->json(['slots' => []]);
        }
        
        $availableSlots = $court->getAvailableSlotsForDate($request->date);
        
        return response()->json(['slots' => $availableSlots]);
    }

    public function submitBooking(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'court_type' => 'required|in:tennis,basketball,football',
            'players' => 'required|integer|min:1|max:22',
            'message' => 'nullable|string|max:2000',
        ]);

        $locale = app()->getLocale();
        $validated['locale'] = $locale;

        $booking = TennisCourtBooking::create($validated);

        // Get admin recipients from settings
        $recipients = Setting::where('key', 'tennis_booking_emails')->first()?->value 
            ?? Setting::where('key', 'admin_email')->first()?->value
            ?? 'vitanov1@yahoo.com';
        
        $emailList = array_map('trim', explode(',', $recipients));

        // Send notification to admins (in their preferred language or default to MK)
        $adminLocale = Setting::where('key', 'admin_email_locale')->first()?->value ?? 'mk';
        foreach ($emailList as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($email)->queue(new TennisBookingReceived($booking, $adminLocale));
            }
        }

        // Send confirmation to user in their language
        Mail::to($booking->email)->queue(new TennisBookingConfirmation($booking, $locale));

        $message = $locale === 'mk' 
            ? 'Ви благодариме за вашата резервација! Ќе ви одговориме во најкраток можен рок.'
            : 'Thank you for your booking request! We will get back to you as soon as possible.';

        return back()->with('success', $message);
    }
}
