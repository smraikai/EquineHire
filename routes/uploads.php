<?php

use App\Http\Controllers\UploadController;

//////////////////////////////////////
// Image Uploads
//////////////////////////////////////
Route::post('/upload/delete', [UploadController::class, 'deleteFile'])->name('upload.delete');
Route::post('/upload/featured-image', [UploadController::class, 'uploadFeaturedImage'])->name('upload.featured_image');
Route::post('/upload/logo', [UploadController::class, 'uploadLogo'])->name('upload.logo');


Route::post('/upload/jobseeker-profile-picture', [UploadController::class, 'uploadProfilePicture'])->name('upload.profile_picture');
Route::post('/upload/jobseeker-resume', [UploadController::class, 'uploadResume'])->name('upload.resume');