<?php

use App\Http\Controllers\Dashboard\Auth\Login;
use App\Http\Controllers\Dashboard\Auth\Logout;
use App\Http\Controllers\Dashboard\Dashboard;
use App\Http\Controllers\Dashboard\Settings\Managements\Accounts;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.default.index');
});
Route::group(['prefix' => 'auth'], function () {
    Route::resource('login', Login::class)->names(['index' => 'login']);
    Route::resource('logout', Logout::class)->names(['index' => 'logout'])->middleware(['auth:account']);
});
Route::group(['prefix' => 'dashboards', 'middleware' => 'auth:account', 'as' => 'dashboards.'], function () {
    Route::resource('',Dashboard::class);

    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::group(['prefix' => 'managements', 'as' => 'managements.'], function () {
            Route::resource('accounts', Accounts::class);
        });
    });
});
