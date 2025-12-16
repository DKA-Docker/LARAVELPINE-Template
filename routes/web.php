<?php

namespace Routes;

use App\Http\Controllers\V1\Frontend\Auth\Index as FrontendAuth;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Reports;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Requests\Create as DeliveriesRequestCreate;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Requests\Index as DeliveriesRequest;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks\Index as DeliveriesTasks;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks\Create as DeliveriesTasksCreate;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks\Show as DeliveriesTasksShow;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Trackings;
use App\Http\Controllers\V1\Frontend\Dashboards\Index as DashboardsIndex;
use App\Http\Controllers\V1\Frontend\Index as FrontendIndex;
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
    Route::resource('/', DashboardsIndex::class)->parameters(['' => 'id']);
    /** Name Group Route dashboards.apps */
    Route::prefix('apps')->name('apps.')->group(function () {
        /** Name Route dashboards.apps.deliveries */
        Route::prefix('deliveries')->name('deliveries.')->group(function () {
            /** Name Route dashboards.apps.deliveries member of resource */
            Route::prefix('requests')->name('requests.')->group(function () {
                Route::resource('/', DeliveriesRequest::class)->parameters(['' => 'id']);
                Route::resource('create', DeliveriesRequestCreate::class);
            });
            Route::prefix('tasks')->name('tasks.')->group(function () {
                Route::resource('/', DeliveriesTasks::class)->parameters(['' => 'id']);
                Route::resource('/create', DeliveriesTasksCreate::class);
                Route::resource('/show', DeliveriesTasksShow::class);
            });
            Route::resource('reports', Reports::class);
        });
        Route::prefix('trackings')->name('trackings.')->group(function () {
            Route::resource('/', Trackings::class)->parameters(['' => 'id']);

        });
    });
});

