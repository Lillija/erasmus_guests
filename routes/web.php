<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;

Route::get('/', [FlightController::class, 'index']);
Route::post('/search-flights', [FlightController::class, 'search']);
Route::post('/book-flight', [FlightController::class, 'bookFlight'])->name('book.flight');
Route::get('/my-bookings', [FlightController::class, 'userBookings'])->name('user.bookings');
