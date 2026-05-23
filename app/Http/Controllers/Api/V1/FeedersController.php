<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeedersRequest;
use App\Http\Resources\FeederResource;
use App\Models\Feeders;
use App\Models\HogPens;
use App\Models\IotDevices;
use Illuminate\Http\JsonResponse;

class FeedersController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return Feeders::class; }
    protected function resourceClass(): string { return FeederResource::class; }
    protected function relationships(): array { return ['hogPen', 'iotDevice']; }
    protected function ownedParentFields(): array { return ['hog_pen_id' => HogPens::class, 'device_id' => IotDevices::class]; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(FeedersRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(Feeders $feeder): JsonResponse { return $this->crudShow($feeder); }
    public function update(FeedersRequest $request, Feeders $feeder): JsonResponse { return $this->crudUpdate($feeder, $request->validated()); }
    public function destroy(Feeders $feeder): JsonResponse { return $this->crudDestroy($feeder); }
}
