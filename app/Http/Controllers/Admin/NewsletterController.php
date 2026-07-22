<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::query();

        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->has('search') && $request->search) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        $subscribers = $query->orderBy('created_at', 'desc')->paginate(25);

        return Inertia::render('Admin/Newsletter/Index', [
            'subscribers' => $subscribers,
            'filters' => $request->only(['status', 'search']),
            'stats' => [
                'total' => NewsletterSubscriber::count(),
                'active' => NewsletterSubscriber::where('is_active', true)->count(),
                'inactive' => NewsletterSubscriber::where('is_active', false)->count(),
            ],
        ]);
    }

    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();

        return back()->with('success', 'Subscriber deleted successfully.');
    }

    public function toggleStatus(NewsletterSubscriber $subscriber)
    {
        $subscriber->update([
            'is_active' => !$subscriber->is_active,
            'unsubscribed_at' => $subscriber->is_active ? now() : null,
        ]);

        return back()->with('success', 'Subscriber status updated.');
    }

    public function export()
    {
        $subscribers = NewsletterSubscriber::where('is_active', true)
            ->orderBy('email')
            ->pluck('email')
            ->toArray();

        $content = implode("\n", $subscribers);

        return response($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="newsletter_subscribers_' . date('Y-m-d') . '.csv"',
        ]);
    }
}
