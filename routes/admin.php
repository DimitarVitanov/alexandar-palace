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
use App\Http\Controllers\Admin\TennisBookingController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/homepage', [HomepageController::class, 'index'])->name('homepage.index');
    Route::put('/homepage', [HomepageController::class, 'update'])->name('homepage.update');
    Route::post('/homepage/upload', [HomepageController::class, 'uploadImage'])->name('homepage.upload');

    Route::resource('pages', PageController::class);
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
        
        Route::get('bookings/calendar', [TennisBookingController::class, 'calendar'])->name('bookings.calendar');
        Route::resource('bookings', TennisBookingController::class);
        Route::post('bookings/{booking}/confirm', [TennisBookingController::class, 'confirm'])->name('bookings.confirm');
        Route::post('bookings/{booking}/cancel', [TennisBookingController::class, 'cancel'])->name('bookings.cancel');
    });
    
    Route::resource('contacts', ContactRequestController::class)->only(['index', 'show', 'destroy']);
    Route::resource('settings', SettingController::class)->only(['index', 'update']);
    Route::resource('users', UserController::class);
});
