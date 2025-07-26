<?php

use App\Http\Controllers\Dashboard\Auth\Login;
use App\Http\Controllers\Dashboard\Auth\Logout;
use App\Http\Controllers\Dashboard\Dashboard;
use App\Http\Controllers\Dashboard\Settings\Managements\Accounts\Accounts;
use App\Http\Controllers\Dashboard\Settings\Managements\Accounts\Components\Create;
use App\Http\Controllers\Dashboard\Settings\Privileges\Permissions\Permissions;
use App\Http\Controllers\Dashboard\Settings\Privileges\Roles\Roles;
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
        Route::group(['prefix' => 'privileges', 'as' => 'privileges.'], function () {
            Route::group(['prefix' => 'permissions', 'as' => 'permissions.'], function () {
                Route::resource('', Permissions::class);
            });
            Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
                Route::resource('', Roles::class);
            });
        });
    });
});
