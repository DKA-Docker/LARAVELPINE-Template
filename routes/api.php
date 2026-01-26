<?php

use App\Http\Controllers\V1\Api\Base\Accounts\Index as Accounts;
use App\Http\Controllers\V1\Api\Auth\Index as ApiAuth;
use Illuminate\Support\Facades\Route;

/** Buat Route Penamaan Api */
Route::name('api.')->group(function () {
    /** Grouping Ke Group Auth Di Dalam Web Routes*/
    Route::prefix('auth')->name('auth.')->group(function () {
        /** Name Route dashboards.apps */
        Route::resource('/', ApiAuth::class)->parameters(['' => 'id']);
        Route::prefix('register')->name('register.')->group(function () {
            Route::resource('/', Accounts::class)->parameters(['' => 'id']);
        });
    });

    Route::middleware(['auth:sanctum'])->prefix('base')->name('base.')->group(function () {
        Route::prefix('accounts')->name('account.')->group(function () {
            Route::get('/', [Accounts::class, 'index']);
            Route::prefix('firebase')->name('firebase.')->group(function () {
                Route::patch('/', [App\Http\Controllers\V1\Api\Base\Accounts\Firebase\Index::class, 'edit']);
            });
        });
    });
});


