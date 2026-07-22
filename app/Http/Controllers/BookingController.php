<?php

namespace App\Http\Controllers;

use App\Mail\BookingAdminNotification;
use App\Mail\BookingRequestReceived;
use App\Models\Booking;
use App\Models\Room;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $rooms = Room::active()->orderBy('sort_order')->get();
        $selectedRoomId = $rooms->firstWhere('slug', $request->query('room'))?->id;

        return Inertia::render('Booking', [
            'rooms' => $rooms,
            'selectedRoomId' => $selectedRoomId,
            'bookingDefaults' => [
                'check_in' => $request->query('check_in', ''),
                'check_out' => $request->query('check_out', ''),
                'adults' => max(1, (int) $request->query('adults', 1)),
                'children' => max(0, (int) $request->query('children', 0)),
            ],
            'seo' => [
                'title' => 'Request a Reservation',
                'description' => 'Request your stay at Alexandar Palace Hotel.',
                'keywords' => 'hotel reservation, book hotel, Alexandar Palace',
                'canonical' => route('booking.create'),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1|max:10',
            'children' => 'required|integer|min:0|max:10',
            'special_requests' => 'nullable|string|max:5000',
        ]);

        $validated['locale'] = app()->getLocale();

        $room = Room::findOrFail($validated['room_id']);
        $totalGuests = $validated['adults'] + $validated['children'];

        if ($totalGuests > $room->max_guests) {
            return back()->withErrors(['adults' => 'This room accommodates a maximum of ' . $room->max_guests . ' guests.']);
        }

        if (!$room->isAvailable($validated['check_in'], $validated['check_out'])) {
            return back()->withErrors(['check_in' => 'This room is no longer available for the selected dates.']);
        }

        $checkIn = new \DateTime($validated['check_in']);
        $checkOut = new \DateTime($validated['check_out']);
        $nights = $checkIn->diff($checkOut)->days;
        $pricePerNight = $room->discounted_price ?? $room->price_per_night;
        $validated['total_price'] = $pricePerNight * $nights;

        $booking = Booking::create($validated);
        $booking->load('room');

        // Send confirmation email to guest
        NotificationService::notifyGuest($booking->email, new BookingRequestReceived($booking, $booking->locale));
        
        // Send notification to admins (using booking_admin_notification template recipients)
        NotificationService::notifyAdmins(new BookingAdminNotification($booking), 'booking_admin_notification');

        return back()->with('success', __('Thank you for your booking request. We will confirm shortly.'));
    }
}
