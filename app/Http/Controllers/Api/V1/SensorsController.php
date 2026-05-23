<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\SensorsRequest;
use App\Http\Resources\SensorResource;
use App\Models\HogPens;
use App\Models\IotDevices;
use App\Models\Sensors;
use Illuminate\Http\JsonResponse;

class SensorsController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return Sensors::class; }
    protected function resourceClass(): string { return SensorResource::class; }
    protected function relationships(): array { return ['hogPen', 'iotDevice']; }
    protected function ownedParentFields(): array { return ['hog_pen_id' => HogPens::class, 'device_id' => IotDevices::class]; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(SensorsRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(Sensors $sensor): JsonResponse { return $this->crudShow($sensor); }
    public function update(SensorsRequest $request, Sensors $sensor): JsonResponse { return $this->crudUpdate($sensor, $request->validated()); }
    public function destroy(Sensors $sensor): JsonResponse { return $this->crudDestroy($sensor); }
}
