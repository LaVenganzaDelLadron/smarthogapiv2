<?php

use App\Http\Controllers\Api\V1\WebHookLogsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function (): void {
    Route::apiResource('webhook-logs', WebHookLogsController::class)->parameters(['webhook-logs' => 'webHookLog']);
    // Analytics workflows are added in a later module.
});
