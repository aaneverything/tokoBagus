<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\transactionController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('updateUser', [UserController::class, 'UpdateUser']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('transactions', [transactionController::class, 'all']);
    Route::post('checkout', [transactionController::class, 'checkout']);
});