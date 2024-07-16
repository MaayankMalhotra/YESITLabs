<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AudioController;

use App\Http\Controllers\DistanceController;




Route::resource('users', UserController::class);
Route::get('users_export', [UserController::class, 'export'])->name('users_export');

Route::post('/upload/audio', [AudioController::class, 'uploadAudio'])->name('upload.audio');

Route::get('/distance', [DistanceController::class, 'index'])->name('distance');
