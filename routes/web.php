<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'mk'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return back();
})->name('locale');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room:slug}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/restaurant', [PageController::class, 'show'])->defaults('slug', 'restaurant')->name('restaurant');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

require __DIR__.'/admin.php';
