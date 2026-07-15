<?php

namespace App\Http\Controllers;

use App\Mail\ContactRequestAdminNotification;
use App\Mail\ContactRequestReceived;
use App\Models\ContactRequest;
use App\Models\Page;
use App\Models\Room;
use App\Models\Setting;
use App\Services\NotificationService;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function __construct(
        protected SeoService $seoService
    ) {}

    public function index()
    {
        $page = Page::with('sections')->where('slug', 'contacts')->active()->first();
        $settings = Setting::all()->keyBy('key');
        $rooms = Room::where('is_active', true)->orderBy('sort_order')->get();
        $siteName = $this->getSettingValue($settings, 'site_name', config('app.name'));

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Contact Us'],
        ];

        return Inertia::render('Contact', [
            'page' => $page,
            'sections' => $page?->sections->keyBy('key'),
            'rooms' => $rooms,
            'settings' => $settings,
            'seo' => [
                'title' => __('Contact Us') . ' | ' . $siteName,
                'description' => __('Contact :hotel for reservations, inquiries, and information. We are here to help you plan your perfect stay.', ['hotel' => $siteName]),
                'keywords' => 'contact hotel, reservations, ' . strtolower($siteName) . ', hotel inquiry, book hotel',
                'canonical' => route('contacts'),
                'schema' => [
                    $this->seoService->getBreadcrumbSchema($breadcrumbs),
                    $this->seoService->getLocalBusinessSchema(),
                    [
                        '@context' => 'https://schema.org',
                        '@type' => 'ContactPage',
                        'name' => 'Contact ' . $siteName,
                        'url' => route('contacts'),
                    ],
                ],
                'alternateUrls' => [
                    'en' => route('contacts', ['locale' => 'en']),
                    'mk' => route('contacts', ['locale' => 'mk']),
                ],
            ],
        ]);
    }

    private function getSettingValue($settings, string $key, $default = '')
    {
        $setting = $settings->get($key);
        if (!$setting) return $default;
        
        $value = $setting->value;
        if (is_array($value)) {
            return $value[app()->getLocale()] ?? $value['en'] ?? $default;
        }
        return $value ?? $default;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $contact = ContactRequest::create($validated);

        // Send confirmation email to guest
        NotificationService::notifyGuest($contact->email, new ContactRequestReceived($contact));
        
        // Send notification to admins
        NotificationService::notifyAdmins(new ContactRequestAdminNotification($contact));

        return back()->with('success', __('Thank you for your message. We will get back to you soon.'));
    }
}
