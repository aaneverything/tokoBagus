<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\anjayController;

Route::get('/', function () {
    return "bajingan cok";
});
Route::get('/dashboard', function () {
    return view('app');
});

Route::get('/babi',[anjayController::class,'index']);
Route::get('/kento',[anjayController::class,'cobaaja']);