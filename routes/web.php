<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CongressController;
use App\Http\Controllers\CelebrationController;
use App\Http\Controllers\TennisRestaurantController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\AmenitiesController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'mk'])) {
        session(['locale' => $locale, 'locale_set_by_user' => true]);
        app()->setLocale($locale);
    }
    return back();
})->name('locale');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room:slug}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/restaurant', [RestaurantController::class, 'index'])->name('restaurant');
Route::get('/tennis-restaurant', [TennisRestaurantController::class, 'index'])->name('tennis-restaurant');
Route::get('/congress-center', [CongressController::class, 'index'])->name('congress');
Route::post('/congress/contact', [CongressController::class, 'submitContact'])->name('congress.contact');
Route::get('/celebrations', [CelebrationController::class, 'index'])->name('celebrations');
Route::post('/celebrations/contact', [CelebrationController::class, 'submitContact'])->name('celebrations.contact');
Route::get('/activities', [ActivitiesController::class, 'index'])->name('activities');
Route::post('/activities/book', [ActivitiesController::class, 'submitBooking'])->name('activities.book');
Route::get('/activities/available-slots', [ActivitiesController::class, 'getAvailableSlots'])->name('activities.slots');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/api/rooms/{room:id}/availability', [BookingController::class, 'checkAvailability'])->name('rooms.availability');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{email}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

Route::get('/amenities', [AmenitiesController::class, 'index'])->name('amenities');
Route::get('/amenities/qr', [AmenitiesController::class, 'qrCode'])->name('amenities.qr');

require __DIR__.'/admin.php';
