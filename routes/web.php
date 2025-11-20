<?php

namespace Routes;

use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Reports;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Requests;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Trackings;
use App\Http\Controllers\V1\Frontend\Dashboards\Index;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboards')->name('dashboards.')->group(function () {
    Route::resource('/',Index::class);
    Route::prefix('apps')->name('apps.')->group(function () {
        Route::prefix('deliveries')->name('deliveries.')->group(function () {
            Route::resource('requests', Requests::class);
            Route::resource('tasks', Tasks::class);
            Route::resource('reports', Reports::class);
        });
        Route::resource('trackings', Trackings::class);
    });
});

