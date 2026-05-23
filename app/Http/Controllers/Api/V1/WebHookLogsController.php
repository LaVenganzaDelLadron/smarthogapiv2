<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebHookLogsRequest;
use App\Http\Resources\WebHookLogResource;
use App\Models\Farms;
use App\Models\WebHookLogs;
use Illuminate\Http\JsonResponse;

class WebHookLogsController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return WebHookLogs::class; }
    protected function resourceClass(): string { return WebHookLogResource::class; }
    protected function relationships(): array { return ['farm']; }
    protected function ownedParentFields(): array { return ['farm_id' => Farms::class]; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(WebHookLogsRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(WebHookLogs $webHookLog): JsonResponse { return $this->crudShow($webHookLog); }
    public function update(WebHookLogsRequest $request, WebHookLogs $webHookLog): JsonResponse { return $this->crudUpdate($webHookLog, $request->validated()); }
    public function destroy(WebHookLogs $webHookLog): JsonResponse { return $this->crudDestroy($webHookLog); }
}
