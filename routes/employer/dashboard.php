<?php

use App\Http\Controllers\EmployerController;

//////////////////////////////////////
// Main Dashboard
//////////////////////////////////////
Route::get('/dashboard', [EmployerController::class, 'index'])->name('dashboard.employers.index');

// Employer Routes
Route::get('/employers', [EmployerController::class, 'employerProfileIndex'])->name('employers.index');
Route::get('/employers/create', [EmployerController::class, 'create'])->name('employers.create');
Route::post('/employers', [EmployerController::class, 'store'])->name('employers.store');

// More specific employer routes
Route::get('/employers/{employer}/edit', [EmployerController::class, 'edit'])->name('employers.edit');
Route::put('/employers/{employer}', [EmployerController::class, 'update'])->name('employers.update');
Route::delete('/employers/{employer}', [EmployerController::class, 'destroy'])->name('employers.destroy');