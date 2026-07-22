<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterWelcome;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $subscriber = NewsletterSubscriber::updateOrCreate(
            ['email' => $validated['email']],
            [
                'is_active' => true,
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ]
        );

        // Send welcome email with current locale
        $locale = app()->getLocale();
        Mail::to($validated['email'])->queue(new NewsletterWelcome($validated['email'], $locale));

        return back()->with('success', __('Successfully subscribed to our newsletter!'));
    }

    public function unsubscribe(Request $request, string $email)
    {
        $subscriber = NewsletterSubscriber::where('email', $email)->first();
        
        if ($subscriber) {
            $subscriber->update([
                'is_active' => false,
                'unsubscribed_at' => now(),
            ]);
        }

        return redirect('/')->with('success', __('You have been unsubscribed from our newsletter.'));
    }
}
