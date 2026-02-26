<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductCategory;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\transactionController;
use App\Http\Controllers\API\UserController;
use App\Models\User;

Route::get('product', [ProductController::class, 'all']);
route::get('categories', [ProductCategory::class, 'all']);

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('checkout', [UserController::class, 'fetch']);
    Route::post('transactions', [UserController::class, 'updateProfile']);
    Route::post('logout', [UserController::class, 'logout']);

    Route::get('transactions', [UserController::class, 'all']);
    Route::post('checkout', [transactionController::class, 'checkout']);
});
