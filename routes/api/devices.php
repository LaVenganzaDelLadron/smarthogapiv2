<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function (): void {
    // IoT and device command routes are added module-by-module.
});
