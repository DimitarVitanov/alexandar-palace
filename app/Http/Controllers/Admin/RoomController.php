<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Rooms/Index', [
            'rooms' => Room::orderBy('sort_order')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Rooms/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:rooms',
            'name' => 'required|array',
            'description' => 'nullable|array',
            'price_per_night' => 'required|numeric',
            'max_guests' => 'required|integer',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        Room::create($validated);

        return redirect()->route('admin.rooms.index')->with('success', __('Room created successfully.'));
    }

    public function edit(Room $room)
    {
        return Inertia::render('Admin/Rooms/Form', [
            'room' => $room->load('media'),
        ]);
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required|array',
            'description' => 'nullable|array',
            'price_per_night' => 'required|numeric',
            'max_guests' => 'required|integer',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $room->update($validated);

        return back()->with('success', __('Room updated successfully.'));
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return back()->with('success', __('Room deleted successfully.'));
    }
}
