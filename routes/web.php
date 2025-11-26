<?php

namespace Routes;

use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Reports;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Requests;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Trackings;
use App\Http\Controllers\V1\Frontend\Dashboards\Index;
use App\Http\Controllers\V1\Frontend\Index as FrontendIndex;
use App\Http\Controllers\V1\Frontend\Auth\Index as FrontendAuth;
use Illuminate\Support\Facades\Route;

/** Sumber Halaman Frontend Utama */
Route::resource('/', FrontendIndex::class);
/** Grouping Ke Group Auth Di Dalam Web Routes*/
Route::prefix('auth')->name('auth.')->group(function () {
    /** Name Route dashboards.apps */
    Route::resource('/', FrontendAuth::class);
});
/** name Route dashboards */
Route::middleware(['auth:web'])->prefix('dashboards')->name('dashboards.')->group(function () {
    /** Name Route dashboards.apps */
    Route::resource('/', Index::class);
    /** Name Group Route dashboards.apps */
    Route::prefix('apps')->name('apps.')->group(function () {
        /** Name Route dashboards.apps.deliveries */
        Route::prefix('deliveries')->name('deliveries.')->group(function () {
            /** Name Route dashboards.apps.deliveries member of resource */
            Route::resource('requests', Requests::class);
            Route::resource('tasks', Tasks::class);
            Route::resource('reports', Reports::class);
        });
        Route::resource('trackings', Trackings::class);
    });
});

