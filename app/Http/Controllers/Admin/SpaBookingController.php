<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpaBooking;
use App\Models\SpaService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SpaBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = SpaBooking::with('spaService');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('service_id')) {
            $query->where('spa_service_id', $request->service_id);
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
            'total' => SpaBooking::count(),
            'pending' => SpaBooking::pending()->count(),
            'confirmed' => SpaBooking::confirmed()->count(),
            'upcoming' => SpaBooking::upcoming()->count(),
            'total_revenue' => SpaBooking::whereIn('status', ['confirmed', 'completed'])
                ->where('payment_status', 'paid')
                ->sum('total_price'),
        ];

        return Inertia::render('Admin/Spa/Bookings/Index', [
            'bookings' => $bookings,
            'services' => SpaService::active()->get(),
            'stats' => $stats,
            'filters' => $request->only(['status', 'service_id', 'search', 'date']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Spa/Bookings/Create', [
            'services' => SpaService::active()->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'spa_service_id' => 'required|exists:spa_services,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'guests' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'special_requests' => 'nullable|string',
            'status' => 'nullable|string',
            'payment_status' => 'nullable|string',
        ]);

        $booking = SpaBooking::create($validated);

        return redirect()->route('admin.spa.bookings.show', $booking)
            ->with('success', __('Spa booking created successfully.'));
    }

    public function show(SpaBooking $booking)
    {
        return Inertia::render('Admin/Spa/Bookings/Show', [
            'booking' => $booking->load('spaService'),
            'services' => SpaService::active()->get(),
        ]);
    }

    public function update(Request $request, SpaBooking $booking)
    {
        $validated = $request->validate([
            'spa_service_id' => 'sometimes|exists:spa_services,id',
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'phone' => 'nullable|string|max:50',
            'booking_date' => 'sometimes|date',
            'start_time' => 'sometimes|date_format:H:i',
            'end_time' => 'sometimes|date_format:H:i',
            'guests' => 'sometimes|integer|min:1',
            'total_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'special_requests' => 'nullable|string',
            'status' => 'nullable|string',
            'payment_status' => 'nullable|string',
        ]);

        $booking->update($validated);

        return back()->with('success', __('Spa booking updated successfully.'));
    }

    public function confirm(SpaBooking $booking)
    {
        $booking->confirm();

        return back()->with('success', __('Booking confirmed successfully.'));
    }

    public function cancel(Request $request, SpaBooking $booking)
    {
        $booking->cancel($request->cancellation_reason);

        return back()->with('success', __('Booking cancelled successfully.'));
    }

    public function destroy(SpaBooking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.spa.bookings.index')
            ->with('success', __('Spa booking deleted successfully.'));
    }

    public function calendar()
    {
        $bookings = SpaBooking::with('spaService')
            ->whereIn('status', ['pending', 'confirmed'])
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'title' => $booking->name . ' - ' . ($booking->spaService?->name['en'] ?? 'Unknown'),
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
                        'service' => $booking->spaService?->name['en'] ?? 'Unknown',
                        'guests' => $booking->guests,
                    ],
                ];
            });

        return Inertia::render('Admin/Spa/Bookings/Calendar', [
            'bookings' => $bookings,
            'services' => SpaService::active()->get(),
        ]);
    }
}
