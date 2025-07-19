<?php

use App\Http\Controllers\Api\Auth\AuthAccountController;
use App\Http\Controllers\Api\Resources\Accounts\ResourcesAccountsController;
use App\Http\Middleware\Api\Auth\ExpectsJSONMiddleware;
use Illuminate\Support\Facades\Route;

// public Routes (can Access Without Login)
Route::group([ 'prefix' => 'auth', 'middleware' => [ExpectsJSONMiddleware::class]], function () {
    Route::post('login', [AuthAccountController::class, 'login']);
    Route::post('verify', [AuthAccountController::class, 'verify']);
    Route::post('logout', [AuthAccountController::class, 'logout'])->middleware(['auth:api']);
});
// protected Resources
Route::group([ 'prefix' => 'resources', 'middleware' => ['auth:api', ExpectsJSONMiddleware::class]],function () {
    Route::resource('accounts', ResourcesAccountsController::class);
});


