<?php

use App\Http\Controllers\Api\Auth\AuthAccountController;
use App\Http\Controllers\Api\Resources\Accounts\ResourcesAccountsController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    // public Routes (can Access Without Login)
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthAccountController::class, 'login']);
    });
    // protected Resources
    Route::prefix('resources')->middleware('auth:sanctum')->group(function () {
        Route::resource('accounts', ResourcesAccountsController::class);
    });
});


