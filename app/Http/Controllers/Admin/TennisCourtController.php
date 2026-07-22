<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TennisCourt;
use App\Models\TennisAvailability;
use App\Traits\HandlesBilingualFields;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TennisCourtController extends Controller
{
    use HandlesBilingualFields;
    public function index()
    {
        return Inertia::render('Admin/Tennis/Courts/Index', [
            'courts' => TennisCourt::withCount('bookings')->orderBy('sort_order')->paginate(20),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Tennis/Courts/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'description' => 'nullable|array',
            'surface_type' => 'required|string',
            'is_indoor' => 'boolean',
            'has_lighting' => 'boolean',
            'price_per_hour' => 'required|numeric|min:0',
            'price_per_hour_peak' => 'nullable|numeric|min:0',
            'featured_image' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']['en']);

        $court = TennisCourt::create($validated);

        // Create default availability (Mon-Sun, 7am-10pm)
        for ($day = 0; $day <= 6; $day++) {
            TennisAvailability::create([
                'tennis_court_id' => $court->id,
                'day_of_week' => $day,
                'open_time' => '07:00',
                'close_time' => '22:00',
                'slot_duration_minutes' => 60,
                'peak_start_time' => '17:00',
                'peak_end_time' => '20:00',
                'is_available' => true,
            ]);
        }

        return redirect()->route('admin.tennis.courts.index')
            ->with('success', __('Tennis court created successfully.'));
    }

    public function edit(TennisCourt $court)
    {
        $courtData = $this->prepareBilingualData(
            $court->load('availability'),
            ['name', 'description']
        );
        
        return Inertia::render('Admin/Tennis/Courts/Edit', [
            'court' => $courtData,
        ]);
    }

    public function update(Request $request, TennisCourt $court)
    {
        $validated = $request->validate([
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'description' => 'nullable|array',
            'surface_type' => 'required|string',
            'is_indoor' => 'boolean',
            'has_lighting' => 'boolean',
            'price_per_hour' => 'required|numeric|min:0',
            'price_per_hour_peak' => 'nullable|numeric|min:0',
            'featured_image' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $court->update($validated);

        return back()->with('success', __('Tennis court updated successfully.'));
    }

    public function updateAvailability(Request $request, TennisCourt $court)
    {
        $validated = $request->validate([
            'availability' => 'required|array',
            'availability.*.day_of_week' => 'required|integer|min:0|max:6',
            'availability.*.open_time' => 'required|date_format:H:i',
            'availability.*.close_time' => 'required|date_format:H:i',
            'availability.*.peak_start_time' => 'nullable|date_format:H:i',
            'availability.*.peak_end_time' => 'nullable|date_format:H:i',
            'availability.*.is_available' => 'boolean',
        ]);

        foreach ($validated['availability'] as $day) {
            TennisAvailability::updateOrCreate(
                ['tennis_court_id' => $court->id, 'day_of_week' => $day['day_of_week']],
                [
                    'open_time' => $day['open_time'],
                    'close_time' => $day['close_time'],
                    'peak_start_time' => $day['peak_start_time'] ?? null,
                    'peak_end_time' => $day['peak_end_time'] ?? null,
                    'is_available' => $day['is_available'] ?? true,
                    'slot_duration_minutes' => 60,
                ]
            );
        }

        return back()->with('success', __('Availability updated successfully.'));
    }

    public function destroy(TennisCourt $court)
    {
        $court->delete();

        return redirect()->route('admin.tennis.courts.index')
            ->with('success', __('Tennis court deleted successfully.'));
    }
}
