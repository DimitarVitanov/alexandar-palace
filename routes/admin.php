<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ContactRequestController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SpaServiceController;
use App\Http\Controllers\Admin\SpaBookingController;
use App\Http\Controllers\Admin\TennisCourtController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\TranslationController;
use App\Http\Controllers\Admin\CongressContactController;
use App\Http\Controllers\Admin\CelebrationContactController;
use App\Http\Controllers\Admin\TennisCourtBookingController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/homepage', [HomepageController::class, 'index'])->name('homepage.index');
    Route::put('/homepage', [HomepageController::class, 'update'])->name('homepage.update');
    Route::post('/homepage/upload', [HomepageController::class, 'uploadImage'])->name('homepage.upload');

    Route::resource('pages', PageController::class)->except(['show']);
    Route::resource('rooms', RoomController::class);
    Route::resource('news', NewsController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('gallery', GalleryController::class);
    
    // Room Bookings
    Route::get('bookings/calendar', [BookingController::class, 'calendar'])->name('bookings.calendar');
    Route::resource('bookings', BookingController::class);
    Route::post('bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('bookings/{booking}/check-in', [BookingController::class, 'checkIn'])->name('bookings.check-in');
    Route::post('bookings/{booking}/check-out', [BookingController::class, 'checkOut'])->name('bookings.check-out');
    
    // Spa Management
    Route::prefix('spa')->name('spa.')->group(function () {
        Route::resource('services', SpaServiceController::class);
        Route::put('services/{service}/availability', [SpaServiceController::class, 'updateAvailability'])->name('services.availability');
        
        Route::get('bookings/calendar', [SpaBookingController::class, 'calendar'])->name('bookings.calendar');
        Route::resource('bookings', SpaBookingController::class);
        Route::post('bookings/{booking}/confirm', [SpaBookingController::class, 'confirm'])->name('bookings.confirm');
        Route::post('bookings/{booking}/cancel', [SpaBookingController::class, 'cancel'])->name('bookings.cancel');
    });
    
    // Tennis Management
    Route::prefix('tennis')->name('tennis.')->group(function () {
        Route::resource('courts', TennisCourtController::class);
        Route::put('courts/{court}/availability', [TennisCourtController::class, 'updateAvailability'])->name('courts.availability');
    });
    
    Route::resource('contacts', ContactRequestController::class)->only(['index', 'show', 'destroy']);
    Route::resource('settings', SettingController::class)->only(['index', 'update']);
    Route::resource('users', UserController::class);
    
    // Restaurant Menu Management
    Route::prefix('menu')->name('menu.')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::post('/categories', [MenuController::class, 'storeCategory'])->name('categories.store');
        Route::put('/categories/{category}', [MenuController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/categories/{category}', [MenuController::class, 'destroyCategory'])->name('categories.destroy');
        Route::post('/categories/{category}/items', [MenuController::class, 'storeItem'])->name('items.store');
        Route::put('/items/{item}', [MenuController::class, 'updateItem'])->name('items.update');
        Route::delete('/items/{item}', [MenuController::class, 'destroyItem'])->name('items.destroy');
    });
    
    // Email Templates
    Route::resource('email-templates', EmailTemplateController::class)->only(['index', 'edit', 'update']);
    Route::get('email-templates/{emailTemplate}/preview', [EmailTemplateController::class, 'preview'])->name('email-templates.preview');
    
    // Newsletter Subscribers
    Route::get('newsletter', [NewsletterController::class, 'index'])->name('newsletter.index');
    Route::delete('newsletter/{subscriber}', [NewsletterController::class, 'destroy'])->name('newsletter.destroy');
    Route::post('newsletter/{subscriber}/toggle', [NewsletterController::class, 'toggleStatus'])->name('newsletter.toggle');
    Route::get('newsletter/export', [NewsletterController::class, 'export'])->name('newsletter.export');
    
    // Translations
    Route::get('translations', [TranslationController::class, 'index'])->name('translations.index');
    Route::get('translations/create', [TranslationController::class, 'create'])->name('translations.create');
    Route::post('translations', [TranslationController::class, 'store'])->name('translations.store');
    Route::get('translations/{translation}/edit', [TranslationController::class, 'edit'])->name('translations.edit');
    Route::put('translations/{translation}', [TranslationController::class, 'update'])->name('translations.update');
    Route::delete('translations/{translation}', [TranslationController::class, 'destroy'])->name('translations.destroy');
    Route::post('translations/sync', [TranslationController::class, 'sync'])->name('translations.sync');
    
    // Congress Center Contacts
    Route::get('congress-contacts', [CongressContactController::class, 'index'])->name('congress-contacts.index');
    Route::get('congress-contacts/{congressContact}', [CongressContactController::class, 'show'])->name('congress-contacts.show');
    Route::delete('congress-contacts/{congressContact}', [CongressContactController::class, 'destroy'])->name('congress-contacts.destroy');
    Route::post('congress-contacts/recipients', [CongressContactController::class, 'updateRecipients'])->name('congress-contacts.recipients');
    
    // Celebration Contacts
    Route::get('celebration-contacts', [CelebrationContactController::class, 'index'])->name('celebration-contacts.index');
    Route::get('celebration-contacts/{celebrationContact}', [CelebrationContactController::class, 'show'])->name('celebration-contacts.show');
    Route::delete('celebration-contacts/{celebrationContact}', [CelebrationContactController::class, 'destroy'])->name('celebration-contacts.destroy');
    Route::post('celebration-contacts/recipients', [CelebrationContactController::class, 'updateRecipients'])->name('celebration-contacts.recipients');
    
    // Tennis Court Bookings (Activities)
    Route::get('tennis-court-bookings', [TennisCourtBookingController::class, 'index'])->name('tennis-court-bookings.index');
    Route::get('tennis-court-bookings/calendar', [TennisCourtBookingController::class, 'calendar'])->name('tennis-court-bookings.calendar');
    Route::get('tennis-court-bookings/{tennisCourtBooking}', [TennisCourtBookingController::class, 'show'])->name('tennis-court-bookings.show');
    Route::put('tennis-court-bookings/{tennisCourtBooking}', [TennisCourtBookingController::class, 'update'])->name('tennis-court-bookings.update');
    Route::post('tennis-court-bookings/{tennisCourtBooking}/confirm', [TennisCourtBookingController::class, 'confirm'])->name('tennis-court-bookings.confirm');
    Route::post('tennis-court-bookings/{tennisCourtBooking}/cancel', [TennisCourtBookingController::class, 'cancel'])->name('tennis-court-bookings.cancel');
    Route::delete('tennis-court-bookings/{tennisCourtBooking}', [TennisCourtBookingController::class, 'destroy'])->name('tennis-court-bookings.destroy');
});
