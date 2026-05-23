<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeviceCredentialsRequest;
use App\Http\Resources\DeviceCredentialResource;
use App\Models\DeviceCredentials;
use App\Models\IotDevices;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DeviceCredentialsController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return DeviceCredentials::class; }
    protected function resourceClass(): string { return DeviceCredentialResource::class; }
    protected function relationships(): array { return ['user', 'iotDevice']; }
    protected function ownedParentFields(): array { return ['user_id' => User::class, 'iot_device_id' => IotDevices::class]; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(DeviceCredentialsRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(DeviceCredentials $deviceCredential): JsonResponse { return $this->crudShow($deviceCredential); }
    public function update(DeviceCredentialsRequest $request, DeviceCredentials $deviceCredential): JsonResponse { return $this->crudUpdate($deviceCredential, $request->validated()); }
    public function destroy(DeviceCredentials $deviceCredential): JsonResponse { return $this->crudDestroy($deviceCredential); }
}
