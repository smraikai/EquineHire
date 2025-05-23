<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    Route::get('/job-listings', [AdminDashboardController::class, 'jobListings'])->name('job-listings');
    Route::get('/employers', [AdminDashboardController::class, 'employers'])->name('employers');
    Route::get('/applications', [AdminDashboardController::class, 'applications'])->name('applications');
    Route::get('/applications/{application}', [AdminDashboardController::class, 'showApplication'])->name('applications.show');
    Route::put('/applications/{application}/status', [AdminDashboardController::class, 'updateApplicationStatus'])->name('applications.update-status');
    Route::get('/revenue', [AdminDashboardController::class, 'revenue'])->name('revenue');
});