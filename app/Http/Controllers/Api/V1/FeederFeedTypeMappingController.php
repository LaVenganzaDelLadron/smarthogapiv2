<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeederFeedTypeMappingRequest;
use App\Http\Resources\FeederFeedTypeMappingResource;
use App\Models\FeederFeedTypeMapping;
use App\Models\Feeders;
use Illuminate\Http\JsonResponse;

class FeederFeedTypeMappingController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return FeederFeedTypeMapping::class; }
    protected function resourceClass(): string { return FeederFeedTypeMappingResource::class; }
    protected function relationships(): array { return ['feeder']; }
    protected function ownedParentFields(): array { return ['feeder_id' => Feeders::class]; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(FeederFeedTypeMappingRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(FeederFeedTypeMapping $feederFeedTypeMapping): JsonResponse { return $this->crudShow($feederFeedTypeMapping); }
    public function update(FeederFeedTypeMappingRequest $request, FeederFeedTypeMapping $feederFeedTypeMapping): JsonResponse { return $this->crudUpdate($feederFeedTypeMapping, $request->validated()); }
    public function destroy(FeederFeedTypeMapping $feederFeedTypeMapping): JsonResponse { return $this->crudDestroy($feederFeedTypeMapping); }
}
