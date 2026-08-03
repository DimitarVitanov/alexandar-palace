<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomInventory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomInventoryController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::with(['inventories' => fn ($query) => $query->orderBy('date_from')])
            ->orderBy('sort_order')
            ->get();

        $selectedRoom = $request->filled('room_id')
            ? $rooms->firstWhere('id', (int) $request->room_id)
            : $rooms->first();

        $start = $request->filled('start')
            ? Carbon::parse($request->start)->startOfMonth()
            : Carbon::today()->startOfMonth();

        $months = min(12, max(1, (int) $request->input('months', 3)));
        $end = $start->copy()->addMonths($months - 1)->endOfMonth();

        return Inertia::render('Admin/RoomInventory/Index', [
            'rooms' => $rooms->map(fn (Room $room) => [
                'id' => $room->id,
                'name' => $room->name,
                'total_units' => $room->total_units,
                'max_guests' => $room->max_guests,
                'inventories' => $room->inventories->map(fn (RoomInventory $inventory) => [
                    'id' => $inventory->id,
                    'date_from' => $inventory->date_from->format('Y-m-d'),
                    'date_to' => $inventory->date_to->format('Y-m-d'),
                    'quantity' => $inventory->quantity,
                    'notes' => $inventory->notes,
                ]),
            ]),
            'selectedRoomId' => $selectedRoom?->id,
            'calendar' => $selectedRoom
                ? array_values($selectedRoom->getAvailabilityCalendar($start, $end))
                : [],
            'range' => [
                'start' => $start->format('Y-m-d'),
                'months' => $months,
            ],
        ]);
    }

    public function store(Request $request, Room $room)
    {
        $validated = $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'quantity' => 'required|integer|min:0|max:1000',
            'notes' => 'nullable|string|max:1000',
        ]);

        $room->inventories()->create($validated);

        return back()->with('success', 'Availability period saved.');
    }

    public function update(Request $request, RoomInventory $inventory)
    {
        $validated = $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'quantity' => 'required|integer|min:0|max:1000',
            'notes' => 'nullable|string|max:1000',
        ]);

        $inventory->update($validated);

        return back()->with('success', 'Availability period updated.');
    }

    public function destroy(RoomInventory $inventory)
    {
        $inventory->delete();

        return back()->with('success', 'Availability period removed.');
    }
}
