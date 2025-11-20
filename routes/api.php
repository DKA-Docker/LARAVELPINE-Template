<?php

use App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Reports;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Requests;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Tasks;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Trackings;
use Illuminate\Support\Facades\Route;

/** Buat Route Penamaan Api */
Route::name('api.')->group(function () {
    /** name Route api.dashboards */
    Route::prefix('dashboards')->name('dashboards.')->group(function () {
        /** Name Route api.dashboards.apps */
        Route::prefix('apps')->name('apps.')->group(function () {
            /** Name Route api.dashboards.apps.deliveries */
            Route::prefix('deliveries')->name('deliveries.')->group(function () {
                /** Name Route api.dashboards.apps.deliveries member of resource */
                Route::resource('requests', Requests::class);
                Route::resource('tasks', Tasks::class);
                Route::resource('reports', Reports::class);
            });
            Route::resource('trackings', Trackings::class);
        });
    });
});


