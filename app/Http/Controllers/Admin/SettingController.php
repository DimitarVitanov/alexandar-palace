<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Settings/Index', [
            'settings' => Setting::all()->groupBy('group'),
        ]);
    }

    public function update(Request $request)
    {
        foreach ($request->input('settings', []) as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        return back()->with('success', __('Settings updated successfully.'));
    }
}
