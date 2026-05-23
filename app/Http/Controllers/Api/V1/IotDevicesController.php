<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\IotDevicesRequest;
use App\Http\Resources\IotDeviceResource;
use App\Models\HogPens;
use App\Models\IotDevices;
use Illuminate\Http\JsonResponse;

class IotDevicesController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return IotDevices::class; }
    protected function resourceClass(): string { return IotDeviceResource::class; }
    protected function relationships(): array { return ['hogPen']; }
    protected function ownedParentFields(): array { return ['hog_pen_id' => HogPens::class]; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(IotDevicesRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(IotDevices $iotDevice): JsonResponse { return $this->crudShow($iotDevice); }
    public function update(IotDevicesRequest $request, IotDevices $iotDevice): JsonResponse { return $this->crudUpdate($iotDevice, $request->validated()); }
    public function destroy(IotDevices $iotDevice): JsonResponse { return $this->crudDestroy($iotDevice); }
}
