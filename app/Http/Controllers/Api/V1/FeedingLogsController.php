<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeedingLogsRequest;
use App\Http\Resources\FeedingLogResource;
use App\Models\Feeders;
use App\Models\FeedingLogs;
use App\Models\HogPens;
use Illuminate\Http\JsonResponse;

class FeedingLogsController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return FeedingLogs::class; }
    protected function resourceClass(): string { return FeedingLogResource::class; }
    protected function relationships(): array { return ['feeder', 'hogPen']; }
    protected function ownedParentFields(): array { return ['feeder_id' => Feeders::class, 'pen_id' => HogPens::class]; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(FeedingLogsRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(FeedingLogs $feedingLog): JsonResponse { return $this->crudShow($feedingLog); }
    public function update(FeedingLogsRequest $request, FeedingLogs $feedingLog): JsonResponse { return $this->crudUpdate($feedingLog, $request->validated()); }
    public function destroy(FeedingLogs $feedingLog): JsonResponse { return $this->crudDestroy($feedingLog); }
}
