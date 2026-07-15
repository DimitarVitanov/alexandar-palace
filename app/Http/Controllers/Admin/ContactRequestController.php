<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactRequestController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Contacts/Index', [
            'contacts' => ContactRequest::latest()->paginate(20),
        ]);
    }

    public function show(ContactRequest $contact)
    {
        $contact->update(['is_read' => true]);

        return Inertia::render('Admin/Contacts/Show', [
            'contact' => $contact,
        ]);
    }

    public function destroy(ContactRequest $contact)
    {
        $contact->delete();

        return back()->with('success', __('Contact request deleted successfully.'));
    }
}
