<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ContactRequest;
use App\Models\News;
use App\Models\Room;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'rooms' => Room::count(),
                'news' => News::count(),
                'pending_bookings' => Booking::where('status', 'pending')->count(),
                'unread_contacts' => ContactRequest::where('is_read', false)->count(),
            ],
            'recent_bookings' => Booking::latest()->limit(5)->get(),
            'recent_contacts' => ContactRequest::latest()->limit(5)->get(),
        ]);
    }
}
