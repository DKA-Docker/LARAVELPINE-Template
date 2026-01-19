<?php

namespace Routes;

use App\Http\Controllers\V1\Frontend\Auth\Index as FrontendAuth;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Reports\Index as DeliveriesReports;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Requests\Create as DeliveriesRequestCreate;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Requests\Edit as DeliveriesRequestEdit;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Requests\Index as DeliveriesRequest;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks\Create as DeliveriesTasksCreate;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks\Edit as DeliveriesTasksEdit;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks\Index as DeliveriesTasks;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Rates\Index as DeliveriesRates;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Sessions\Index as DeliveriesSessions;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Rates\Categories\Index as DeliveriesRatesCategories;
use App\Http\Controllers\V1\Frontend\Dashboards\Apps\Trackings;
use App\Http\Controllers\V1\Frontend\Dashboards\Index as DashboardsIndex;
use App\Http\Controllers\V1\Frontend\Dashboards\Managements\Accounts\Create as ManagementsAccountsCreate;
use App\Http\Controllers\V1\Frontend\Dashboards\Managements\Accounts\Edit as ManagementsAccountsEdit;
use App\Http\Controllers\V1\Frontend\Dashboards\Managements\Accounts\Index as ManagementsAccountsIndex;
use App\Http\Controllers\V1\Frontend\Index as FrontendIndex;
use App\Http\Controllers\V1\Frontend\Resources\Index as FrontendResources;
use App\Http\Controllers\V1\Frontend\Dashboards\Settings\Vehicles\Index as SettingsVehiclesIndex;
use App\Http\Controllers\V1\Frontend\Dashboards\Settings\Vehicles\Create as SettingsVehiclesCreate;
use App\Http\Controllers\V1\Frontend\Dashboards\Settings\Vehicles\Edit as SettingsVehiclesEdit;
use App\Http\Controllers\V1\Frontend\Dashboards\Settings\Vehicles\Categories\Create as SettingsVehiclesCategoriesCreate;
use App\Http\Controllers\V1\Frontend\Dashboards\Settings\Vehicles\Categories\Edit as SettingsVehiclesCategoriesEdit;
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
    /** Name Route dashboards.apps */
    Route::resource('/', DashboardsIndex::class)->parameters(['' => 'id']);

    /** Session Check Endpoint */
    Route::get('/check-session', function () {
        return response()->json(['status' => 'valid']);
    })->name('check-session');

    /** Name Group Route dashboards.apps */
    Route::prefix('apps')->name('apps.')->group(function () {
        /** Name Route dashboards.apps.deliveries */
        Route::prefix('deliveries')->name('deliveries.')->group(function () {
            /** Name Route dashboards.apps.deliveries member of resource */
            Route::prefix('requests')->name('requests.')->group(function () {
                Route::resource('/', DeliveriesRequest::class)->parameters(['' => 'id']);
                Route::prefix('create')->name('create.')->group(function () {
                    Route::resource('/', DeliveriesRequestCreate::class);
                    Route::get('/geocoding-proxy', [DeliveriesRequestCreate::class, 'geocodingProxy'])->name('geocodingProxy');
                });
                Route::prefix('{id}/edit')->name('edit.')->group(function () {
                    Route::get('/', [DeliveriesRequestEdit::class, 'index'])->name('index');
                });
            });
            Route::prefix('tasks')->name('tasks.')->group(function () {
                Route::prefix('sessions')->name('sessions.')->group(function () {
                    Route::resource('/', DeliveriesSessions::class)->parameters(['' => 'id']);
                });
                Route::resource('/', DeliveriesTasks::class)->parameters(['' => 'id']);
                Route::prefix('create')->name('create.')->group(function () {
                    Route::resource('/', DeliveriesTasksCreate::class);
                    Route::get('/geocoding-proxy', [DeliveriesTasksCreate::class, 'geocodingProxy'])->name('geocodingProxy');
                });
                Route::prefix('{id}/edit')->name('edit.')->group(function () {
                    Route::get('/', [DeliveriesTasksEdit::class, 'index'])->name('index');
                });
            });
            Route::prefix('reports')->name('reports.')->group(function () {
                Route::resource('/', DeliveriesReports::class)->parameters(['' => 'id']);
            });
            Route::prefix('rates')->name('rates.')->group(function () {
                Route::resource('/', DeliveriesRates::class)->parameters(['' => 'id']);
                Route::prefix('categories')->name('categories.')->group(function () {
                    Route::resource('/', DeliveriesRatesCategories::class);
                });
            });


        });
        Route::prefix('trackings')->name('trackings.')->group(function () {
            Route::get('/', [Trackings\Index::class,'index'])->name('index');
            Route::prefix('monitors')->name('monitors.')->group(function () {
                Route::resource('/', Trackings\Monitors\Index::class);
                Route::post('/request-location-update',[Trackings\Monitors\Index::class, 'ReqLocationUpdate'])->name('ReqLocationUpdate');
                Route::post('/request-alarm',[Trackings\Monitors\Index::class, 'ReqAlarm'])->name('ReqAlarm');
            });
        });

    });

    Route::prefix('managements')->name('managements.')->group(function () {
        Route::prefix('accounts')->name('accounts.')->group(function () {
            Route::resource('/',ManagementsAccountsIndex::class);
            Route::prefix('create')->name('create.')->group(function () {
                Route::resource('/', ManagementsAccountsCreate::class);
            });
            Route::prefix('{id}/edit')->name('edit.')->group(function () {
                Route::get('/', [ManagementsAccountsEdit::class, 'index'])->name('index');
            });
        });
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::prefix('vehicles')->name('vehicles.')->group(function () {
            Route::resource('/', SettingsVehiclesIndex::class);
            
            Route::prefix('create')->name('create.')->group(function () {
                 Route::resource('/', SettingsVehiclesCreate::class);
            });
            Route::prefix('{id}/edit')->name('edit.')->group(function () {
                Route::get('/', [SettingsVehiclesEdit::class, 'index'])->name('index');
            });

             Route::prefix('categories')->name('categories.')->group(function () {
                 Route::prefix('create')->name('create.')->group(function () {
                     Route::resource('/', SettingsVehiclesCategoriesCreate::class);
                 });
                 Route::prefix('{id}/edit')->name('edit.')->group(function () {
                     Route::get('/', [SettingsVehiclesCategoriesEdit::class, 'index'])->name('index');
                 });
            });
        });
    });
});

