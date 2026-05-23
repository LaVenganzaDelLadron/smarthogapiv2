<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlertsRequest;
use App\Http\Resources\AlertResource;
use App\Models\Alerts;
use App\Models\Farms;
use App\Models\HogPens;
use Illuminate\Http\JsonResponse;

class AlertsController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return Alerts::class; }
    protected function resourceClass(): string { return AlertResource::class; }
    protected function relationships(): array { return ['farm', 'hogPen']; }
    protected function ownedParentFields(): array { return ['farm_id' => Farms::class, 'hog_pen_id' => HogPens::class]; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(AlertsRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(Alerts $alert): JsonResponse { return $this->crudShow($alert); }
    public function update(AlertsRequest $request, Alerts $alert): JsonResponse { return $this->crudUpdate($alert, $request->validated()); }
    public function destroy(Alerts $alert): JsonResponse { return $this->crudDestroy($alert); }
}
