<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductCategory;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\transactionController;
use App\Http\Controllers\API\CartController;

Route::get('product', [ProductController::class, 'all']);
Route::get('categories', [ProductCategory::class, 'all']);

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('updateUser', [UserController::class, 'UpdateUser']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('transactions', [transactionController::class, 'all']);
    Route::post('checkout', [transactionController::class, 'checkout']);

    // Cart routes
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart/add', [CartController::class, 'add']);
    Route::put('cart/{id}', [CartController::class, 'update']);
    Route::delete('cart/{id}', [CartController::class, 'remove']);
    Route::post('cart/clear', [CartController::class, 'clear']);
});

