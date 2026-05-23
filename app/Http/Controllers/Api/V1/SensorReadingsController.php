<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\SensorReadingsRequest;
use App\Http\Resources\SensorReadingResource;
use App\Models\SensorReadings;
use App\Models\Sensors;
use Illuminate\Http\JsonResponse;

class SensorReadingsController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return SensorReadings::class; }
    protected function resourceClass(): string { return SensorReadingResource::class; }
    protected function relationships(): array { return ['sensor']; }
    protected function ownedParentFields(): array { return ['sensor_id' => Sensors::class]; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(SensorReadingsRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(SensorReadings $sensorReading): JsonResponse { return $this->crudShow($sensorReading); }
    public function update(SensorReadingsRequest $request, SensorReadings $sensorReading): JsonResponse { return $this->crudUpdate($sensorReading, $request->validated()); }
    public function destroy(SensorReadings $sensorReading): JsonResponse { return $this->crudDestroy($sensorReading); }
}
