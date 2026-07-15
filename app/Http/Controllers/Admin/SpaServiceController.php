<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpaService;
use App\Models\SpaAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class SpaServiceController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Spa/Services/Index', [
            'services' => SpaService::withCount('bookings')->orderBy('sort_order')->paginate(20),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Spa/Services/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'description' => 'nullable|array',
            'duration_minutes' => 'required|integer|min:15',
            'price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'category' => 'required|string',
            'featured_image' => 'nullable|string',
            'max_guests' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']['en']);

        $service = SpaService::create($validated);

        // Create default availability (Mon-Sun, 9am-6pm)
        for ($day = 0; $day <= 6; $day++) {
            SpaAvailability::create([
                'spa_service_id' => $service->id,
                'day_of_week' => $day,
                'open_time' => '09:00',
                'close_time' => '18:00',
                'slot_duration_minutes' => $service->duration_minutes,
                'max_concurrent_bookings' => 1,
                'is_available' => true,
            ]);
        }

        return redirect()->route('admin.spa.services.index')
            ->with('success', __('Spa service created successfully.'));
    }

    public function edit(SpaService $service)
    {
        return Inertia::render('Admin/Spa/Services/Edit', [
            'service' => $service->load('availability'),
        ]);
    }

    public function update(Request $request, SpaService $service)
    {
        $validated = $request->validate([
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'description' => 'nullable|array',
            'duration_minutes' => 'required|integer|min:15',
            'price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'category' => 'required|string',
            'featured_image' => 'nullable|string',
            'max_guests' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $service->update($validated);

        return back()->with('success', __('Spa service updated successfully.'));
    }

    public function updateAvailability(Request $request, SpaService $service)
    {
        $validated = $request->validate([
            'availability' => 'required|array',
            'availability.*.day_of_week' => 'required|integer|min:0|max:6',
            'availability.*.open_time' => 'required|date_format:H:i',
            'availability.*.close_time' => 'required|date_format:H:i',
            'availability.*.is_available' => 'boolean',
            'availability.*.max_concurrent_bookings' => 'integer|min:1',
        ]);

        foreach ($validated['availability'] as $day) {
            SpaAvailability::updateOrCreate(
                ['spa_service_id' => $service->id, 'day_of_week' => $day['day_of_week']],
                [
                    'open_time' => $day['open_time'],
                    'close_time' => $day['close_time'],
                    'is_available' => $day['is_available'] ?? true,
                    'max_concurrent_bookings' => $day['max_concurrent_bookings'] ?? 1,
                    'slot_duration_minutes' => $service->duration_minutes,
                ]
            );
        }

        return back()->with('success', __('Availability updated successfully.'));
    }

    public function destroy(SpaService $service)
    {
        $service->delete();

        return redirect()->route('admin.spa.services.index')
            ->with('success', __('Spa service deleted successfully.'));
    }
}
