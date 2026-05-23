<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeviceLogsRequest;
use App\Http\Resources\DeviceLogResource;
use App\Models\DeviceLogs;
use App\Models\IotDevices;
use Illuminate\Http\JsonResponse;

class DeviceLogsController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return DeviceLogs::class; }
    protected function resourceClass(): string { return DeviceLogResource::class; }
    protected function relationships(): array { return ['iotDevice']; }
    protected function ownedParentFields(): array { return ['device_id' => IotDevices::class]; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(DeviceLogsRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(DeviceLogs $deviceLog): JsonResponse { return $this->crudShow($deviceLog); }
    public function update(DeviceLogsRequest $request, DeviceLogs $deviceLog): JsonResponse { return $this->crudUpdate($deviceLog, $request->validated()); }
    public function destroy(DeviceLogs $deviceLog): JsonResponse { return $this->crudDestroy($deviceLog); }
}
