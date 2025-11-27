<?php

use App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Reports;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Requests as Requests;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Tasks;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Trackings as Trackings;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Trackings\Monitors as TrackingsMonitors;
use Illuminate\Support\Facades\Route;

/** Buat Route Penamaan Api */
Route::middleware(['Api'])->name('api.')->group(function () {
    /** name Route api.dashboards */
    Route::prefix('dashboards')->name('dashboards.')->group(function () {
        /** Name Route api.dashboards.apps */
        Route::prefix('apps')->name('apps.')->group(function () {
            /** Name Route api.dashboards.apps.deliveries */
            Route::prefix('deliveries')->name('deliveries.')->group(function () {
                /** Name Route api.dashboards.apps.deliveries member of resource */
                Route::resource('requests', Requests\Index::class);
                Route::resource('tasks', Tasks::class);
                Route::resource('reports', Reports::class);
            });
            Route::prefix('trackings')->name('trackings.')->group(function () {
                Route::resource('/', Trackings\Index::class);
                Route::prefix('monitors')->name('monitors.')->group(function () {
                    Route::resource('/', TrackingsMonitors\Index::class);
                });
            });
        });
    });
});


