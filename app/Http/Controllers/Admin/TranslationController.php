<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $query = Translation::query();

        if ($request->filled('group')) {
            $query->where('group', $request->group);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('key', 'like', "%{$search}%")
                  ->orWhere('value', 'like', "%{$search}%");
            });
        }

        if ($request->filled('locale')) {
            $query->where('locale', $request->locale);
        }

        $translations = $query->orderBy('group')
            ->orderBy('key')
            ->orderBy('locale')
            ->paginate(50)
            ->withQueryString();

        $groups = Translation::select('group')
            ->distinct()
            ->orderBy('group')
            ->pluck('group');

        return Inertia::render('Admin/Translations/Index', [
            'translations' => $translations,
            'groups' => $groups,
            'filters' => $request->only(['group', 'search', 'locale']),
        ]);
    }

    public function edit(Translation $translation)
    {
        // Get the matching translation in the other locale
        $otherLocale = $translation->locale === 'en' ? 'mk' : 'en';
        $otherTranslation = Translation::where('group', $translation->group)
            ->where('key', $translation->key)
            ->where('locale', $otherLocale)
            ->first();

        return Inertia::render('Admin/Translations/Edit', [
            'translation' => $translation,
            'otherTranslation' => $otherTranslation,
        ]);
    }

    public function update(Request $request, Translation $translation)
    {
        $validated = $request->validate([
            'value' => 'required|string',
            'other_value' => 'nullable|string',
        ]);

        $translation->update(['value' => $validated['value']]);

        // Update the other locale if provided
        if ($request->filled('other_value')) {
            $otherLocale = $translation->locale === 'en' ? 'mk' : 'en';
            Translation::updateOrCreate(
                [
                    'group' => $translation->group,
                    'key' => $translation->key,
                    'locale' => $otherLocale,
                ],
                ['value' => $validated['other_value']]
            );
        }

        Translation::clearCache();

        return redirect()->route('admin.translations.index')
            ->with('success', 'Translation updated successfully.');
    }

    public function create()
    {
        $groups = Translation::select('group')
            ->distinct()
            ->orderBy('group')
            ->pluck('group');

        return Inertia::render('Admin/Translations/Create', [
            'groups' => $groups,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'group' => 'required|string|max:100',
            'key' => 'required|string|max:100',
            'value_en' => 'required|string',
            'value_mk' => 'required|string',
        ]);

        Translation::updateOrCreate(
            ['group' => $validated['group'], 'key' => $validated['key'], 'locale' => 'en'],
            ['value' => $validated['value_en']]
        );

        Translation::updateOrCreate(
            ['group' => $validated['group'], 'key' => $validated['key'], 'locale' => 'mk'],
            ['value' => $validated['value_mk']]
        );

        Translation::clearCache();

        return redirect()->route('admin.translations.index')
            ->with('success', 'Translation created successfully.');
    }

    public function destroy(Translation $translation)
    {
        // Delete both locales
        Translation::where('group', $translation->group)
            ->where('key', $translation->key)
            ->delete();

        Translation::clearCache();

        return redirect()->route('admin.translations.index')
            ->with('success', 'Translation deleted successfully.');
    }

    public function sync()
    {
        // Import default translations from messages.js structure
        $defaults = $this->getDefaultTranslations();
        
        foreach ($defaults as $locale => $groups) {
            foreach ($groups as $group => $keys) {
                foreach ($keys as $key => $value) {
                    Translation::firstOrCreate(
                        ['group' => $group, 'key' => $key, 'locale' => $locale],
                        ['value' => $value]
                    );
                }
            }
        }

        Translation::clearCache();

        return redirect()->route('admin.translations.index')
            ->with('success', 'Translations synced from defaults.');
    }

    private function getDefaultTranslations(): array
    {
        return [
            'en' => [
                'nav' => [
                    'home' => 'Home',
                    'rooms' => 'Rooms & Suites',
                    'about' => 'About',
                    'restaurant' => 'Restaurant',
                    'gallery' => 'Gallery',
                    'news' => 'News & Events',
                    'contact' => 'Contacts',
                    'book_now' => 'Book Now',
                ],
                'footer' => [
                    'contacts' => 'Contacts',
                    'explore' => 'Explore',
                    'newsletter' => 'Newsletter',
                    'newsletter_placeholder' => 'Your email',
                    'newsletter_text' => 'Receive latest offers and promos without spam. You can cancel anytime.',
                    'copyright' => '© Aleksandar Palace. All rights reserved.',
                ],
                'home' => [
                    'hero_small' => 'Welcome to Aleksandar Palace',
                    'hero_title' => 'A unique Experience where to stay',
                    'check_in_out' => 'Check in / Check out',
                    'adults' => 'Adults',
                    'children' => 'Children',
                    'search' => 'Search',
                    'about_small' => 'About us',
                    'about_title' => 'Tailored services and the experience of unique holidays',
                    'rooms_small' => 'Luxury experience',
                    'rooms_title' => 'Rooms & Suites',
                    'view_all_rooms' => 'View all Rooms',
                    'facilities_small' => 'Aleksandar Palace',
                    'facilities_title' => 'Main Facilities',
                    'news_small' => 'Luxury experience',
                    'news_title' => 'News & Events',
                    'view_all_news' => 'View all News',
                    'booking_small' => 'Aleksandar Palace',
                    'booking_title' => 'Check Availability',
                    'booking_info' => 'Info and bookings',
                    'read_more' => 'Read more',
                ],
                'contact' => [
                    'hero_subtitle' => 'Get in Touch',
                    'hero_title' => 'Contact Us',
                    'get_in_touch' => 'Get in Touch',
                    'name' => 'Name',
                    'last_name' => 'Last name',
                    'email' => 'Email',
                    'telephone' => 'Telephone',
                    'message' => 'Message',
                    'submit' => 'Submit',
                    'success_message' => 'Thank you for your message! We will get back to you as soon as possible.',
                    'address' => 'Address',
                    'phone' => 'Phone',
                    'email_label' => 'Email',
                    'airport' => 'Airport',
                    'railway_station' => 'Railway Station',
                    'bus_station' => 'Bus Station',
                    'city_center' => 'City Center',
                    'city_park' => 'City Park',
                    'ski_center_mavrovo' => 'Ski Center Mavrovo',
                    'ohrid_lake' => 'Ohrid Lake',
                    'airport_timetable' => 'Skopje Airport Timetable',
                    'border_with' => 'Border with',
                    'minutes' => 'minutes',
                    'minute' => 'minute',
                    'hotel_bistra' => 'Hotel Bistra/Mavrovo',
                    'hotel_metropol' => 'Hotel Metropol & Bellevue',
                    'serbia' => 'Serbia',
                    'bulgaria' => 'Bulgaria',
                    'greece' => 'Greece',
                    'albania' => 'Albania',
                ],
                'restaurant' => [
                    'title' => 'Restaurant',
                    'description' => 'Experience culinary excellence at our award-winning restaurant.',
                ],
                'about' => [
                    'local_amenities_text' => 'Discover the best of Skopje right at your doorstep.',
                ],
            ],
            'mk' => [
                'nav' => [
                    'home' => 'Дома',
                    'rooms' => 'Соби и Апартмани',
                    'about' => 'За Нас',
                    'restaurant' => 'Ресторан',
                    'gallery' => 'Галерија',
                    'news' => 'Новости и Настани',
                    'contact' => 'Контакт',
                    'book_now' => 'Резервирај Сега',
                ],
                'footer' => [
                    'contacts' => 'Контакти',
                    'explore' => 'Истражете',
                    'newsletter' => 'Билтен',
                    'newsletter_placeholder' => 'Вашата е-пошта',
                    'newsletter_text' => 'Добивајте најнови понуди и промоции без спам. Можете да се откажете во секое време.',
                    'copyright' => '© Александар Палас. Сите права задржани.',
                ],
                'home' => [
                    'hero_small' => 'Добредојдовте во Александар Палас',
                    'hero_title' => 'Уникатно искуство за одмор',
                    'check_in_out' => 'Пријава / Одјава',
                    'adults' => 'Возрасни',
                    'children' => 'Деца',
                    'search' => 'Пребарај',
                    'about_small' => 'За нас',
                    'about_title' => 'Прилагодени услуги и искуство на единствен одмор',
                    'rooms_small' => 'Луксузно искуство',
                    'rooms_title' => 'Соби и Апартмани',
                    'view_all_rooms' => 'Види ги сите соби',
                    'facilities_small' => 'Александар Палас',
                    'facilities_title' => 'Главни Содржини',
                    'news_small' => 'Луксузно искуство',
                    'news_title' => 'Новости и Настани',
                    'view_all_news' => 'Види ги сите новости',
                    'booking_small' => 'Александар Палас',
                    'booking_title' => 'Проверете достапност',
                    'booking_info' => 'Инфо и резервации',
                    'read_more' => 'Прочитај повеќе',
                ],
                'contact' => [
                    'hero_subtitle' => 'Контактирајте нè',
                    'hero_title' => 'Контакт',
                    'get_in_touch' => 'Контактирајте нè',
                    'name' => 'Име',
                    'last_name' => 'Презиме',
                    'email' => 'Е-пошта',
                    'telephone' => 'Телефон',
                    'message' => 'Порака',
                    'submit' => 'Испрати',
                    'success_message' => 'Ви благодариме за вашата порака! Ќе ви одговориме во најкраток можен рок.',
                    'address' => 'Адреса',
                    'phone' => 'Телефон',
                    'email_label' => 'Е-пошта',
                    'airport' => 'Аеродром',
                    'railway_station' => 'Железничка станица',
                    'bus_station' => 'Автобуска станица',
                    'city_center' => 'Центар на град',
                    'city_park' => 'Градски парк',
                    'ski_center_mavrovo' => 'Ски центар Маврово',
                    'ohrid_lake' => 'Охридско езеро',
                    'airport_timetable' => 'Распоред на летови',
                    'border_with' => 'Граница со',
                    'minutes' => 'минути',
                    'minute' => 'минута',
                    'hotel_bistra' => 'Хотел Бистра/Маврово',
                    'hotel_metropol' => 'Хотел Метропол & Белвју',
                    'serbia' => 'Србија',
                    'bulgaria' => 'Бугарија',
                    'greece' => 'Грција',
                    'albania' => 'Албанија',
                ],
                'restaurant' => [
                    'title' => 'Ресторан',
                    'description' => 'Доживејте кулинарска извонредност во нашиот награден ресторан.',
                ],
                'about' => [
                    'local_amenities_text' => 'Откријте го најдоброто од Скопје директно пред вашата врата.',
                ],
            ],
        ];
    }
}
