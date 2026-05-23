<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\PredictionCacheRequest;
use App\Http\Resources\PredictionCacheResource;
use App\Models\HogPens;
use App\Models\PredictionCache;
use Illuminate\Http\JsonResponse;

class PredictionCacheController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return PredictionCache::class; }
    protected function resourceClass(): string { return PredictionCacheResource::class; }
    protected function relationships(): array { return ['hogPen']; }
    protected function ownedParentFields(): array { return ['pen_id' => HogPens::class]; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(PredictionCacheRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(PredictionCache $predictionCache): JsonResponse { return $this->crudShow($predictionCache); }
    public function update(PredictionCacheRequest $request, PredictionCache $predictionCache): JsonResponse { return $this->crudUpdate($predictionCache, $request->validated()); }
    public function destroy(PredictionCache $predictionCache): JsonResponse { return $this->crudDestroy($predictionCache); }
}
