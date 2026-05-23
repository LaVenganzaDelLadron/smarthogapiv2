<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeedingScheduleRequest;
use App\Http\Resources\FeedingScheduleResource;
use App\Models\FeedingSchedule;
use App\Models\HogPens;
use Illuminate\Http\JsonResponse;

class FeedingScheduleController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return FeedingSchedule::class; }
    protected function resourceClass(): string { return FeedingScheduleResource::class; }
    protected function relationships(): array { return ['hogPen']; }
    protected function ownedParentFields(): array { return ['hog_pen_id' => HogPens::class]; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(FeedingScheduleRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(FeedingSchedule $feedingSchedule): JsonResponse { return $this->crudShow($feedingSchedule); }
    public function update(FeedingScheduleRequest $request, FeedingSchedule $feedingSchedule): JsonResponse { return $this->crudUpdate($feedingSchedule, $request->validated()); }
    public function destroy(FeedingSchedule $feedingSchedule): JsonResponse { return $this->crudDestroy($feedingSchedule); }
}
