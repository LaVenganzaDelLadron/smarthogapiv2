<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\MlModelsRequest;
use App\Http\Resources\MlModelResource;
use App\Models\MlModels;
use Illuminate\Http\JsonResponse;

class MlModelsController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return MlModels::class; }
    protected function resourceClass(): string { return MlModelResource::class; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(MlModelsRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(MlModels $mlModel): JsonResponse { return $this->crudShow($mlModel); }
    public function update(MlModelsRequest $request, MlModels $mlModel): JsonResponse { return $this->crudUpdate($mlModel, $request->validated()); }
    public function destroy(MlModels $mlModel): JsonResponse { return $this->crudDestroy($mlModel); }
}
