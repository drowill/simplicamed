<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiGoogle\GoogleController;

Route::get('auth/google', [GoogleController::class, 'googleLogin'])->name('google.login');
Route::get('auth/google-callback', [GoogleController::class, 'googleAuthentication']);

