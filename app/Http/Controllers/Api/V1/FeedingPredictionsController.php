<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeedingPredictionsRequest;
use App\Http\Resources\FeedingPredictionResource;
use App\Models\FeedingPredictions;
use App\Models\HogPens;
use App\Models\MlModels;
use Illuminate\Http\JsonResponse;

class FeedingPredictionsController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return FeedingPredictions::class; }
    protected function resourceClass(): string { return FeedingPredictionResource::class; }
    protected function relationships(): array { return ['hogPen', 'mlModel']; }
    protected function ownedParentFields(): array { return ['hog_pen_id' => HogPens::class]; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(FeedingPredictionsRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(FeedingPredictions $feedingPrediction): JsonResponse { return $this->crudShow($feedingPrediction); }
    public function update(FeedingPredictionsRequest $request, FeedingPredictions $feedingPrediction): JsonResponse { return $this->crudUpdate($feedingPrediction, $request->validated()); }
    public function destroy(FeedingPredictions $feedingPrediction): JsonResponse { return $this->crudDestroy($feedingPrediction); }
}
