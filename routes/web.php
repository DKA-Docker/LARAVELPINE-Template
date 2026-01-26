<?php

namespace Routes;

use App\Http\Controllers\V1\Frontend\Auth\Index as FrontendAuth;
use App\Http\Controllers\V1\Frontend\Index as FrontendIndex;
use App\Http\Controllers\V1\Frontend\Resources\Index as FrontendResources;
use Illuminate\Support\Facades\Route;

/** Sumber Halaman Frontend Utama */
Route::resource('/', FrontendIndex::class);
/** Privacy Policy - Public Access */
Route::prefix('privacy')->name('privacy.')->group(function () {
    Route::resource('/', FrontendResources::class);
});
/** Grouping Ke Group Auth Di Dalam Web Routes*/
Route::prefix('auth')->name('auth.')->group(function () {
    Route::resource('/', FrontendAuth::class);
    /** Register Route */
    Route::get('/register', [FrontendAuth::class, 'register'])->name('register');
    /** Forgot Password Route */
    Route::get('/forgot-password', [FrontendAuth::class, 'forgotPassword'])->name('forgot-password');
});
/** name Route dashboards */
Route::middleware(['auth:web'])->prefix('dashboards')->name('dashboards.')->group(function () {
    //
});

