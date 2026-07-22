<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TennisBookingApproved;
use App\Models\CourtSetting;
use App\Models\TennisCourtBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class TennisCourtBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = TennisCourtBooking::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('court_type')) {
            $query->where('court_type', $request->court_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date')) {
            $query->where('booking_date', $request->date);
        }

        $bookings = $query->latest()->paginate(20)->withQueryString();

        // Mark as read when viewing
        TennisCourtBooking::where('is_read', false)->update(['is_read' => true]);

        $stats = [
            'total' => TennisCourtBooking::count(),
            'pending' => TennisCourtBooking::pending()->count(),
            'confirmed' => TennisCourtBooking::confirmed()->count(),
            'upcoming' => TennisCourtBooking::upcoming()->count(),
        ];

        $courts = CourtSetting::active()->get();

        return Inertia::render('Admin/TennisCourtBookings/Index', [
            'bookings' => $bookings,
            'stats' => $stats,
            'filters' => $request->only(['status', 'court_type', 'search', 'date']),
            'courts' => $courts,
        ]);
    }

    public function calendar(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        $selectedDate = Carbon::parse($date);
        
        $courts = CourtSetting::active()->get();
        
        $bookings = TennisCourtBooking::whereDate('booking_date', $selectedDate)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->get();
        
        // Build schedule grid for each court
        $schedule = [];
        foreach ($courts as $court) {
            $courtKey = "{$court->court_type}_{$court->court_number}";
            $schedule[$courtKey] = [
                'court' => $court,
                'slots' => [],
            ];
            
            foreach ($court->available_slots as $slot) {
                $booking = $bookings->first(function ($b) use ($court, $slot) {
                    return $b->court_type === $court->court_type 
                        && $b->court_number === $court->court_number
                        && substr($b->start_time, 0, 5) === $slot;
                });
                
                $schedule[$courtKey]['slots'][$slot] = $booking;
            }
        }
        
        return Inertia::render('Admin/TennisCourtBookings/Calendar', [
            'schedule' => $schedule,
            'courts' => $courts,
            'selectedDate' => $selectedDate->format('Y-m-d'),
            'bookings' => $bookings,
        ]);
    }

    public function show(TennisCourtBooking $tennisCourtBooking)
    {
        return Inertia::render('Admin/TennisCourtBookings/Show', [
            'booking' => $tennisCourtBooking,
        ]);
    }

    public function update(Request $request, TennisCourtBooking $tennisCourtBooking)
    {
        $validated = $request->validate([
            'status' => 'sometimes|in:pending,confirmed,cancelled,completed',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $tennisCourtBooking->update($validated);

        return back()->with('success', 'Booking updated successfully.');
    }

    public function confirm(TennisCourtBooking $tennisCourtBooking)
    {
        $tennisCourtBooking->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        // Send approval email to user in their preferred language
        Mail::to($tennisCourtBooking->email)->queue(
            new TennisBookingApproved($tennisCourtBooking, $tennisCourtBooking->locale)
        );

        return back()->with('success', 'Booking confirmed and notification sent to customer.');
    }

    public function cancel(TennisCourtBooking $tennisCourtBooking)
    {
        $tennisCourtBooking->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Booking cancelled.');
    }

    public function destroy(TennisCourtBooking $tennisCourtBooking)
    {
        $tennisCourtBooking->delete();

        return redirect()->route('admin.tennis-court-bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }
}
