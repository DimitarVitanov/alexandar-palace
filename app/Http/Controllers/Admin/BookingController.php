<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BookingCancelled;
use App\Mail\BookingConfirmed;
use App\Models\Booking;
use App\Models\Room;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('room');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('booking_reference', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->where('check_in', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('check_out', '<=', $request->date_to);
        }

        $bookings = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::pending()->count(),
            'confirmed' => Booking::confirmed()->count(),
            'upcoming' => Booking::upcoming()->count(),
            'current_guests' => Booking::currentGuests()->count(),
            'total_revenue' => Booking::whereIn('status', ['confirmed', 'checked_in', 'checked_out'])
                ->where('payment_status', 'paid')
                ->sum('total_price'),
        ];

        return Inertia::render('Admin/Bookings/Index', [
            'bookings' => $bookings,
            'rooms' => Room::active()->get(),
            'stats' => $stats,
            'filters' => $request->only(['status', 'payment_status', 'room_id', 'search', 'date_from', 'date_to']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Bookings/Create', [
            'rooms' => Room::active()->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'total_price' => 'nullable|numeric|min:0',
            'deposit_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'special_requests' => 'nullable|string',
            'status' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'payment_method' => 'nullable|string',
        ]);

        $booking = Booking::create($validated);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', __('Booking created successfully.'));
    }

    public function show(Booking $booking)
    {
        return Inertia::render('Admin/Bookings/Show', [
            'booking' => $booking->load('room'),
            'rooms' => Room::active()->get(),
        ]);
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'room_id' => 'sometimes|exists:rooms,id',
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'phone' => 'nullable|string|max:50',
            'check_in' => 'sometimes|date',
            'check_out' => 'sometimes|date|after:check_in',
            'adults' => 'sometimes|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'total_price' => 'nullable|numeric|min:0',
            'deposit_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'special_requests' => 'nullable|string',
            'status' => 'nullable|string',
            'payment_status' => 'nullable|string',
            'payment_method' => 'nullable|string',
        ]);

        $booking->update($validated);

        return back()->with('success', __('Booking updated successfully.'));
    }

    public function confirm(Booking $booking)
    {
        $booking->confirm();
        
        // Send confirmation email to guest
        NotificationService::notifyGuest($booking->email, new BookingConfirmed($booking));

        return back()->with('success', __('Booking confirmed successfully.'));
    }

    public function cancel(Request $request, Booking $booking)
    {
        $booking->cancel($request->cancellation_reason);
        $booking->load('room');
        NotificationService::notifyGuest($booking->email, new BookingCancelled($booking));

        return back()->with('success', __('Booking cancelled successfully.'));
    }

    public function checkIn(Booking $booking)
    {
        $booking->checkIn();

        return back()->with('success', __('Guest checked in successfully.'));
    }

    public function checkOut(Booking $booking)
    {
        $booking->checkOut();

        return back()->with('success', __('Guest checked out successfully.'));
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', __('Booking deleted successfully.'));
    }

    public function calendar()
    {
        $bookings = Booking::with('room')
            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'title' => $booking->name . ' - ' . ($booking->room?->name['en'] ?? 'No Room'),
                    'start' => $booking->check_in->format('Y-m-d'),
                    'end' => $booking->check_out->format('Y-m-d'),
                    'color' => match($booking->status) {
                        'pending' => '#ffc107',
                        'confirmed' => '#28a745',
                        'checked_in' => '#17a2b8',
                        default => '#6c757d',
                    },
                    'extendedProps' => [
                        'booking_reference' => $booking->booking_reference,
                        'status' => $booking->status,
                        'room' => $booking->room?->name['en'] ?? 'No Room',
                        'guests' => $booking->adults + $booking->children,
                    ],
                ];
            });

        return Inertia::render('Admin/Bookings/Calendar', [
            'bookings' => $bookings,
            'rooms' => Room::active()->get(),
        ]);
    }
}
