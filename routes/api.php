<?php

use App\Http\Controllers\Api\Auth\AuthAccountController;
use App\Http\Controllers\Api\Resources\Accounts\ResourcesAccountsController;
use Illuminate\Support\Facades\Route;

// public Routes (can Access Without Login)
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthAccountController::class, 'login']);
    Route::post('register', [AuthAccountController::class, 'register']);
});
// protected Resources
Route::prefix('resources')->middleware(['auth:api'])->group(function () {
    Route::resource('accounts', ResourcesAccountsController::class);
});


