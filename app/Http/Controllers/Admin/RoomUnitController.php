<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomUnit;
use App\Models\RoomUnitAvailability;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomUnitController extends Controller
{
    public function index()
    {
        $rooms = Room::with(['units' => function ($query) {
            $query->withCount(['availabilities', 'bookings']);
        }])->orderBy('sort_order')->get();

        return Inertia::render('Admin/RoomUnits/Index', [
            'rooms' => $rooms,
        ]);
    }

    public function create(Room $room)
    {
        return Inertia::render('Admin/RoomUnits/Form', [
            'room' => $room,
            'unit' => null,
        ]);
    }

    public function store(Request $request, Room $room)
    {
        $validated = $request->validate([
            'unit_code' => 'required|string|max:20|unique:room_units,unit_code,NULL,id,room_id,' . $room->id,
            'floor' => 'nullable|string|max:10',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $room->units()->create($validated);

        return redirect()->route('admin.room-units.index')
            ->with('success', 'Room unit created successfully.');
    }

    public function edit(RoomUnit $roomUnit)
    {
        $roomUnit->load('room');

        return Inertia::render('Admin/RoomUnits/Form', [
            'room' => $roomUnit->room,
            'unit' => $roomUnit,
        ]);
    }

    public function update(Request $request, RoomUnit $roomUnit)
    {
        $validated = $request->validate([
            'unit_code' => 'required|string|max:20|unique:room_units,unit_code,' . $roomUnit->id . ',id,room_id,' . $roomUnit->room_id,
            'floor' => 'nullable|string|max:10',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $roomUnit->update($validated);

        return redirect()->route('admin.room-units.index')
            ->with('success', 'Room unit updated successfully.');
    }

    public function destroy(RoomUnit $roomUnit)
    {
        $roomUnit->delete();

        return redirect()->route('admin.room-units.index')
            ->with('success', 'Room unit deleted successfully.');
    }

    // Availability management
    public function availability(RoomUnit $roomUnit)
    {
        $roomUnit->load(['room', 'availabilities' => function ($query) {
            $query->orderBy('available_from');
        }]);

        return Inertia::render('Admin/RoomUnits/Availability', [
            'unit' => $roomUnit,
        ]);
    }

    public function storeAvailability(Request $request, RoomUnit $roomUnit)
    {
        $validated = $request->validate([
            'available_from' => 'required|date',
            'available_to' => 'required|date|after:available_from',
            'status' => 'required|in:available,blocked,maintenance',
            'notes' => 'nullable|string',
        ]);

        $roomUnit->availabilities()->create($validated);

        return back()->with('success', 'Availability period added successfully.');
    }

    public function updateAvailability(Request $request, RoomUnitAvailability $availability)
    {
        $validated = $request->validate([
            'available_from' => 'required|date',
            'available_to' => 'required|date|after:available_from',
            'status' => 'required|in:available,blocked,maintenance',
            'notes' => 'nullable|string',
        ]);

        $availability->update($validated);

        return back()->with('success', 'Availability period updated successfully.');
    }

    public function destroyAvailability(RoomUnitAvailability $availability)
    {
        $availability->delete();

        return back()->with('success', 'Availability period deleted successfully.');
    }
}
