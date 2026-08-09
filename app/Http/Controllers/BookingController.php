<?php

namespace App\Http\Controllers;

use App\Mail\BookingAdminNotification;
use App\Mail\BookingRequestReceived;
use App\Models\Booking;
use App\Models\Room;
use App\Services\NotificationService;
use Carbon\Carbon;
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
                'title' => 'Request a Reservation | Alexandar Palace',
                'description' => 'Request your stay at Alexandar Palace Hotel. Book your luxury accommodation in Skopje, Macedonia.',
                'keywords' => 'hotel reservation, book hotel, Alexandar Palace, Skopje accommodation',
                'canonical' => route('booking.create'),
                'schema' => [
                    [
                        '@context' => 'https://schema.org',
                        '@type' => 'ReserveAction',
                        'target' => [
                            '@type' => 'EntryPoint',
                            'urlTemplate' => route('booking.create'),
                            'actionPlatform' => [
                                'http://schema.org/DesktopWebPlatform',
                                'http://schema.org/MobileWebPlatform',
                            ],
                        ],
                        'object' => [
                            '@type' => 'LodgingReservation',
                            'reservationFor' => [
                                '@type' => 'LodgingBusiness',
                                'name' => 'Alexandar Palace Hotel',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'rooms_count' => 'required|integer|min:1|max:100',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'passport_id' => 'required|string|max:100',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1|max:10',
            'children' => 'required|integer|min:0|max:10',
            'special_requests' => 'nullable|string|max:5000',
        ]);

        $validated['locale'] = app()->getLocale();

        $room = Room::with('inventories')->findOrFail($validated['room_id']);
        $roomsCount = max(1, (int) $validated['rooms_count']);
        $totalGuests = $validated['adults'] + $validated['children'];

        if ($totalGuests > $room->max_guests * $roomsCount) {
            return back()->withErrors(['adults' => 'The selected rooms accommodate a maximum of ' . ($room->max_guests * $roomsCount) . ' guests.']);
        }

        $availableRooms = $room->getAvailableUnits($validated['check_in'], $validated['check_out']);

        if ($availableRooms < $roomsCount) {
            return back()->withErrors([
                'check_in' => $availableRooms > 0
                    ? 'Only ' . $availableRooms . ' room(s) of this type are available for the selected dates.'
                    : 'This room type is no longer available for the selected dates.',
            ]);
        }

        $checkIn = new \DateTime($validated['check_in']);
        $checkOut = new \DateTime($validated['check_out']);
        $nights = $checkIn->diff($checkOut)->days;
        $pricePerNight = $room->discounted_price ?? $room->price_per_night;
        $validated['total_price'] = $pricePerNight * $nights * $roomsCount;
        $validated['rooms_count'] = $roomsCount;

        $booking = Booking::create($validated);
        $booking->load('room');

        // Send confirmation email to guest
        NotificationService::notifyGuest($booking->email, new BookingRequestReceived($booking, $booking->locale));
        
        // Send notification to admins (using booking_admin_notification template recipients)
        NotificationService::notifyAdmins(new BookingAdminNotification($booking), 'booking_admin_notification');

        return back()->with('success', __('Thank you for your booking request. We will confirm shortly.'));
    }

    public function checkAvailability(Request $request, Room $room)
    {
        $checkIn = $request->query('check_in');
        $checkOut = $request->query('check_out');
        $roomsCount = max(1, (int) $request->query('rooms_count', 1));

        if (!$checkIn || !$checkOut) {
            return response()->json(['available' => false, 'available_rooms' => 0, 'message' => 'Dates are required']);
        }

        $room->load('inventories');

        $availableRooms = $room->getAvailableUnits($checkIn, $checkOut);
        $isAvailable = $availableRooms >= $roomsCount;
        $locale = app()->getLocale();

        if ($isAvailable) {
            $message = $locale === 'mk'
                ? 'Достапни соби: ' . $availableRooms
                : $availableRooms . ' room(s) available';
        } elseif ($availableRooms > 0) {
            $message = $locale === 'mk'
                ? 'Само ' . $availableRooms . ' соба(и) се достапни за избраните датуми.'
                : 'Only ' . $availableRooms . ' room(s) available for the selected dates.';
        } else {
            $message = $locale === 'mk'
                ? 'Не е достапно за избраните датуми'
                : 'Not available for selected dates';
        }

        return response()->json([
            'available' => $isAvailable,
            'available_rooms' => $availableRooms,
            'requested_rooms' => $roomsCount,
            'message' => $message,
        ]);
    }

    /**
     * Per-date availability for the mini calendars on the booking page.
     */
    public function availabilityCalendar(Request $request, Room $room)
    {
        $start = $request->query('start')
            ? Carbon::parse($request->query('start'))->startOfMonth()
            : Carbon::today()->startOfMonth();

        $months = min(12, max(1, (int) $request->query('months', 3)));
        $end = $start->copy()->addMonths($months - 1)->endOfMonth();

        $room->load('inventories');

        return response()->json([
            'room_id' => $room->id,
            'start' => $start->format('Y-m-d'),
            'end' => $end->format('Y-m-d'),
            'days' => array_values($room->getAvailabilityCalendar($start, $end)),
        ]);
    }
}
