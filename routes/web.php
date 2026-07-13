<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;

// Rute Publik Pengunjung
Route::get('/', [SiteController::class, 'home'])->name('home');

use App\Http\Controllers\DestinationController;
Route::get('/destination', [DestinationController::class, 'index'])->name('destination.index');

Route::get('/destination/{slug}', [SiteController::class, 'destination'])->name('destination.show');
Route::get('/hotel/{slug}', [SiteController::class, 'hotel'])->name('hotel.show');
Route::get('/article/{slug}', [SiteController::class, 'article'])->name('article');
Route::get('/exclusive-rates', [SiteController::class, 'exclusiveRates'])->name('exclusive-rates');
Route::get('/hotelbrands', [SiteController::class, 'hotelBrands'])->name('hotel-brands');
Route::get('/recommended-hotels', [SiteController::class, 'recommendedHotels'])->name('recommended-hotels');
Route::get('/best-hotels', [SiteController::class, 'bestHotels'])->name('best-hotels');
Route::get('/terms-and-conditions', [SiteController::class, 'termsAndConditions'])->name('terms-and-conditions');

// Rute Pemesanan Hotel (Sidebar Form)
use App\Http\Controllers\BookingController;
Route::post('/booking/request', [BookingController::class, 'store'])->name('booking.request');

// Rute B2B
use App\Http\Controllers\B2bInfoController;
Route::get('/b2bhotel', [B2bInfoController::class, 'index'])->name('b2bhotel.index');
Route::get('/join-us', [B2bInfoController::class, 'joinUs'])->name('join-us');

use App\Http\Controllers\HowWeWorkController;
Route::get('/how-we-work', [HowWeWorkController::class, 'index'])->name('how-we-work');

// Rute News & Journal
use App\Http\Controllers\ArticleController;
Route::get('/news', [ArticleController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [ArticleController::class, 'show'])->name('news.show');

// Rute About Us
use App\Http\Controllers\AboutController;
Route::get('/about', [AboutController::class, 'index'])->name('about');