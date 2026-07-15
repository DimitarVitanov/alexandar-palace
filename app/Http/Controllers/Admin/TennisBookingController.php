<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TennisBooking;
use App\Models\TennisCourt;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TennisBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = TennisBooking::with('tennisCourt');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('court_id')) {
            $query->where('tennis_court_id', $request->court_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('booking_reference', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date')) {
            $query->where('booking_date', $request->date);
        }

        $bookings = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total' => TennisBooking::count(),
            'pending' => TennisBooking::pending()->count(),
            'confirmed' => TennisBooking::confirmed()->count(),
            'upcoming' => TennisBooking::upcoming()->count(),
            'total_revenue' => TennisBooking::whereIn('status', ['confirmed', 'completed'])
                ->where('payment_status', 'paid')
                ->sum('total_price'),
        ];

        return Inertia::render('Admin/Tennis/Bookings/Index', [
            'bookings' => $bookings,
            'courts' => TennisCourt::active()->get(),
            'stats' => $stats,
            'filters' => $request->only(['status', 'court_id', 'search', 'date']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Tennis/Bookings/Create', [
            'courts' => TennisCourt::active()->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tennis_court_id' => 'required|exists:tennis_courts,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'players' => 'required|integer|min:1|max:4',
            'equipment_rental' => 'boolean',
            'total_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'nullable|string',
            'payment_status' => 'nullable|string',
        ]);

        $booking = TennisBooking::create($validated);

        return redirect()->route('admin.tennis.bookings.show', $booking)
            ->with('success', __('Tennis booking created successfully.'));
    }

    public function show(TennisBooking $booking)
    {
        return Inertia::render('Admin/Tennis/Bookings/Show', [
            'booking' => $booking->load('tennisCourt'),
            'courts' => TennisCourt::active()->get(),
        ]);
    }

    public function update(Request $request, TennisBooking $booking)
    {
        $validated = $request->validate([
            'tennis_court_id' => 'sometimes|exists:tennis_courts,id',
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'phone' => 'nullable|string|max:50',
            'booking_date' => 'sometimes|date',
            'start_time' => 'sometimes|date_format:H:i',
            'end_time' => 'sometimes|date_format:H:i',
            'players' => 'sometimes|integer|min:1|max:4',
            'equipment_rental' => 'boolean',
            'total_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'nullable|string',
            'payment_status' => 'nullable|string',
        ]);

        $booking->update($validated);

        return back()->with('success', __('Tennis booking updated successfully.'));
    }

    public function confirm(TennisBooking $booking)
    {
        $booking->confirm();

        return back()->with('success', __('Booking confirmed successfully.'));
    }

    public function cancel(Request $request, TennisBooking $booking)
    {
        $booking->cancel($request->cancellation_reason);

        return back()->with('success', __('Booking cancelled successfully.'));
    }

    public function destroy(TennisBooking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.tennis.bookings.index')
            ->with('success', __('Tennis booking deleted successfully.'));
    }

    public function calendar()
    {
        $bookings = TennisBooking::with('tennisCourt')
            ->whereIn('status', ['pending', 'confirmed'])
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'title' => $booking->name . ' - ' . ($booking->tennisCourt?->name['en'] ?? 'Unknown'),
                    'start' => $booking->booking_date->format('Y-m-d') . 'T' . $booking->start_time,
                    'end' => $booking->booking_date->format('Y-m-d') . 'T' . $booking->end_time,
                    'color' => match($booking->status) {
                        'pending' => '#ffc107',
                        'confirmed' => '#28a745',
                        default => '#6c757d',
                    },
                    'extendedProps' => [
                        'booking_reference' => $booking->booking_reference,
                        'status' => $booking->status,
                        'court' => $booking->tennisCourt?->name['en'] ?? 'Unknown',
                        'players' => $booking->players,
                    ],
                ];
            });

        return Inertia::render('Admin/Tennis/Bookings/Calendar', [
            'bookings' => $bookings,
            'courts' => TennisCourt::active()->get(),
        ]);
    }
}
