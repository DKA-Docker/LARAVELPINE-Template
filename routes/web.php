<?php

use App\Http\Controllers\Backend\Dashboard;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/'], function () {
    Route::get('/', function () {
        return view('frontend.default.index');
    });
    Route::group(['prefix' => '/dashboard'], function () {
        Route::resource('/',Dashboard::class);
    });
});
