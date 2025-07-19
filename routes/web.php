<?php

use App\Http\Controllers\Dashboard\Auth\Login;
use App\Http\Controllers\Dashboard\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.default.index');
});
Route::group(['prefix' => 'auth'], function () {
    Route::resource('login', Login::class)->names(['index' => 'login']);
});
Route::group(['prefix' => 'dashboards', 'middleware' => 'auth:web'], function () {
    Route::resource('',Dashboard::class)->names(['index' => 'dashboards']);
});
