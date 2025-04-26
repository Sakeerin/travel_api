<?php

use App\Http\Controllers\Api\V1\TourController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TravelController;


Route::prefix('v1')->group(function () {
    Route::get('/travels', [TravelController::class, 'index']);
    Route::get('/travels/{travel:slug}/tours', [TourController::class, 'index']);
});
// Route::get('/travels', [TravelController::class, 'index']);