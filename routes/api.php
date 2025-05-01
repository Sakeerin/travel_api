<?php

use App\Http\Controllers\Api\V1\Admin\TourController as AdminTourController;
use App\Http\Controllers\Api\V1\Admin\TravelController as AdminTravelController;
use App\Http\Controllers\Api\V1\Auth\LoginConteoller;
use App\Http\Controllers\Api\V1\TourController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TravelController;


Route::prefix('v1')->group(function () {
    Route::get('/travels', [TravelController::class, 'index']);
    Route::get('/travels/{travel:slug}/tours', [TourController::class, 'index']);
    Route::post('/login', [LoginConteoller::class, 'login']);
    // Route::post('/admin/travels', [AdminTravelController::class, 'store']);
});

Route::prefix('v1/admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/travels', [AdminTravelController::class, 'store']);
    Route::post('/travels/{travel}/tours', [AdminTourController::class, 'store']);
});

// Route::post('/v1/login', [\App\Http\Controllers\Api\V1\Auth\LoginConteoller::class, '__invoke']);
// Route::get('/travels', [TravelController::class, 'index']);