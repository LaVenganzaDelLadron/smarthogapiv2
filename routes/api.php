<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    require __DIR__.'/api/auth.php';
    require __DIR__.'/api/farms.php';
    require __DIR__.'/api/hogs.php';
    require __DIR__.'/api/feeding.php';
    require __DIR__.'/api/devices.php';
    require __DIR__.'/api/predictions.php';
    require __DIR__.'/api/analytics.php';
});
