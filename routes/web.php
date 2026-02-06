<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;

Route::get('/', [FlightController::class, 'index']);
Route::post('/search-flights', [FlightController::class, 'search']);
