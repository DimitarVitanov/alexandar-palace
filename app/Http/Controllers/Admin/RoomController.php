<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Traits\HandlesBilingualFields;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomController extends Controller
{
    use HandlesBilingualFields;
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
            'short_description' => 'nullable|array',
            'amenities' => 'nullable|array',
            'price_per_night' => 'required|numeric',
            'discounted_price' => 'nullable|numeric',
            'quantity' => 'required|integer|min:1',
            'max_guests' => 'required|integer',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'square_meters' => 'nullable|integer',
            'featured_image' => 'nullable|string',
            'gallery_images' => 'nullable|array',
            'view_type' => 'nullable|string',
            'bed_type' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['available_quantity'] = $validated['quantity'];

        Room::create($validated);

        return redirect()->route('admin.rooms.index')->with('success', __('Room created successfully.'));
    }

    public function edit(Room $room)
    {
        $roomData = $this->prepareBilingualData(
            $room->load('media'),
            ['name', 'description', 'short_description']
        );
        
        return Inertia::render('Admin/Rooms/Form', [
            'room' => $roomData,
        ]);
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required|array',
            'description' => 'nullable|array',
            'short_description' => 'nullable|array',
            'amenities' => 'nullable|array',
            'price_per_night' => 'required|numeric',
            'discounted_price' => 'nullable|numeric',
            'quantity' => 'required|integer|min:1',
            'max_guests' => 'required|integer',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'square_meters' => 'nullable|integer',
            'featured_image' => 'nullable|string',
            'gallery_images' => 'nullable|array',
            'view_type' => 'nullable|string',
            'bed_type' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
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
