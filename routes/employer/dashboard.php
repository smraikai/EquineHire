<?php

use App\Http\Controllers\Employer\EmployerController;
use App\Http\Controllers\Employer\EmployerProfileController;

//////////////////////////////////////
// Main Dashboard
//////////////////////////////////////
Route::get('/dashboard', [EmployerController::class, 'index'])->name('dashboard.employers.index');

// Employer Routes
Route::get('/employers', [EmployerProfileController::class, 'index'])->name('employers.index');
Route::get('/employers/create', [EmployerProfileController::class, 'create'])->name('employers.create');
Route::post('/employers', [EmployerProfileController::class, 'store'])->name('employers.store');


Route::get('/employers/{employer}/edit', [EmployerProfileController::class, 'edit'])->name('employers.edit');
Route::put('/employers/{employer}', [EmployerProfileController::class, 'update'])->name('employers.update');
Route::delete('/employers/{employer}', [EmployerProfileController::class, 'destroy'])->name('employers.destroy');