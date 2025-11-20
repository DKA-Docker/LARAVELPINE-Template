<?php

use App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Reports;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Requests;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Tasks;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Trackings;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::prefix('dashboards')->name('dashboards.')->group(function () {
        Route::prefix('apps')->name('apps.')->group(function () {
            Route::prefix('deliveries')->name('deliveries.')->group(function () {
                Route::resource('requests', Requests::class);
                Route::resource('tasks', Tasks::class);
                Route::resource('reports', Reports::class);
            });
            Route::resource('trackings', Trackings::class);
        });
    });
});


