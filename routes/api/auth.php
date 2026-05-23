<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthController::class)->group(function (): void {
    Route::post('/login', 'login')->middleware('throttle:5,1');

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::get('/me', 'me');
        Route::post('/logout', 'logout')->middleware('throttle:10,1');
        Route::post('/refresh-token', 'refreshToken')->middleware('throttle:10,1');
        Route::post('/reject-token', 'rejectToken')->middleware('throttle:10,1');
    });
});
