<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CelebrationContact;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CelebrationContactController extends Controller
{
    public function index(Request $request)
    {
        $query = CelebrationContact::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('event_type', 'like', "%{$search}%");
            });
        }

        $contacts = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $emailRecipients = Setting::where('key', 'celebration_contact_emails')->first()?->value 
            ?? 'vitanov1@yahoo.com';

        return Inertia::render('Admin/CelebrationContacts/Index', [
            'contacts' => $contacts,
            'filters' => $request->only(['search']),
            'emailRecipients' => $emailRecipients,
        ]);
    }

    public function show(CelebrationContact $celebrationContact)
    {
        if (!$celebrationContact->is_read) {
            $celebrationContact->update(['is_read' => true]);
        }

        return Inertia::render('Admin/CelebrationContacts/Show', [
            'contact' => $celebrationContact,
        ]);
    }

    public function destroy(CelebrationContact $celebrationContact)
    {
        $celebrationContact->delete();

        return redirect()->route('admin.celebration-contacts.index')
            ->with('success', 'Contact request deleted.');
    }

    public function updateRecipients(Request $request)
    {
        $validated = $request->validate([
            'emails' => 'required|string',
        ]);

        Setting::updateOrCreate(
            ['key' => 'celebration_contact_emails'],
            [
                'value' => $validated['emails'],
                'label' => 'Celebration Contact Emails',
                'type' => 'text',
            ]
        );

        return back()->with('success', 'Email recipients updated successfully.');
    }
}
