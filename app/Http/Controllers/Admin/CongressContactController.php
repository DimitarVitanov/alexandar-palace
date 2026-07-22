<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CongressContact;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CongressContactController extends Controller
{
    public function index(Request $request)
    {
        $query = CongressContact::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $contacts = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        // Get current email recipients setting
        $emailRecipients = Setting::where('key', 'congress_contact_emails')->first()?->value 
            ?? 'vitanov1@yahoo.com';

        return Inertia::render('Admin/CongressContacts/Index', [
            'contacts' => $contacts,
            'filters' => $request->only(['search']),
            'emailRecipients' => $emailRecipients,
        ]);
    }

    public function show(CongressContact $congressContact)
    {
        if (!$congressContact->is_read) {
            $congressContact->update(['is_read' => true]);
        }

        return Inertia::render('Admin/CongressContacts/Show', [
            'contact' => $congressContact,
        ]);
    }

    public function destroy(CongressContact $congressContact)
    {
        $congressContact->delete();

        return redirect()->route('admin.congress-contacts.index')
            ->with('success', 'Contact request deleted.');
    }

    public function updateRecipients(Request $request)
    {
        $validated = $request->validate([
            'emails' => 'required|string',
        ]);

        Setting::updateOrCreate(
            ['key' => 'congress_contact_emails'],
            ['value' => $validated['emails']]
        );

        return back()->with('success', 'Email recipients updated successfully.');
    }
}
