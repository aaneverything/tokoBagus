<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductCategory;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;

Route::get('product', [ProductController::class, 'all']);
Route::get('categories', [ProductCategory::class, 'all']);

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
