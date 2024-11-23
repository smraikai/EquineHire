<?php

use App\Http\Controllers\LocationController;

// Locatino Routes
Route::post('/location/update', [LocationController::class, 'update'])->name('location.update');
Route::get('/location/current', [LocationController::class, 'current'])->name('location.current');