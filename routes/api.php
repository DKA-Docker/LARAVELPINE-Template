<?php

use App\Http\Controllers\V1\Api\Base\Accounts\Index as Accounts;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Reports;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Requests as Requests;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Requests\Destinations as Destinations;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Task as Tasks;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Task\Sessions as Sessions;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Deliveries\Task\Routes as Routes;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Trackings\Monitors as TrackingsMonitors;
use App\Http\Controllers\V1\Api\Dashboards\Apps\Trackings\Alarms as TrackingsAlarms;
use App\Http\Controllers\V1\Api\Dashboards\Managements\Accounts as ManagementAccounts;
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
    /** name Route api.dashboards */
    Route::middleware(['auth:sanctum'])->prefix('dashboards')->name('dashboards.')->group(function () {
        /** Name Route api.dashboards.apps */
        Route::prefix('apps')->name('apps.')->group(function () {
            /** Name Route api.dashboards.apps.deliveries */
            Route::prefix('deliveries')->name('deliveries.')->group(function () {
                /** Name Route api.dashboards.apps.deliveries member of resource */
                Route::prefix('requests')->name('requests.')->group(function () {
                    Route::resource('/', Requests\Index::class);
                    Route::prefix('destinations')->name('destinations.')->group(function () {
                        Route::resource('/', Destinations\Index::class);
                    });
                });
                Route::prefix('tasks')->name('tasks.')->group(function () {
                    Route::resource('/', Tasks\Index::class)->parameters(['' => 'id']);
                    Route::prefix('routes')->name('routes.')->group(function () {
                        Route::resource('/', Routes\Index::class)->parameters(['' => 'id']);
                    });
                    Route::prefix('attachments')->name('attachments.')->group(function () {
                         Route::resource('/', Tasks\Attachments\Index::class)->parameters(['' => 'id']);
                    });
                    Route::prefix('sessions')->name('sessions.')->group(function () {
                        Route::resource('/', Tasks\Sessions\Index::class)->parameters(['' => 'id']);
                    });
                });
                Route::resource('reports', Reports::class);
            });
            Route::prefix('trackings')->name('trackings.')->group(function () {
                Route::prefix('monitors')->name('monitors.')->group(function () {
                    Route::resource('/', TrackingsMonitors\Index::class);
                });
                Route::prefix('alarms')->name('alarms.')->group(function () {
                    Route::resource('/', TrackingsAlarms\Index::class);
                });
            });
        });

        Route::prefix('managements')->name('managements.')->group(function () {
            Route::prefix('accounts')->name('accounts.')->group(function () {
                Route::resource('/', ManagementAccounts\Index::class);
            });
        });

    });

    Route::middleware(['auth:sanctum'])->prefix('base')->name('base.')->group(function () {
        Route::prefix('accounts')->name('account.')->group(function () {
            Route::get('/', [Accounts\Index::class, 'index']);
            Route::prefix('firebase')->name('firebase.')->group(function () {
                Route::patch('/', [Accounts\Firebase\Index::class, 'edit']);
            });
        });
    });
});


