<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\HogDailyRecordsRequest;
use App\Http\Resources\HogDailyRecordResource;
use App\Models\HogDailyRecords;
use App\Models\HogPens;
use App\Models\Hogs;
use Illuminate\Http\JsonResponse;

class HogDailyRecordsController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return HogDailyRecords::class; }
    protected function resourceClass(): string { return HogDailyRecordResource::class; }
    protected function relationships(): array { return ['hog', 'hogPen']; }
    protected function ownedParentFields(): array { return ['hog_id' => Hogs::class, 'hog_pen_id' => HogPens::class]; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(HogDailyRecordsRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(HogDailyRecords $hogDailyRecord): JsonResponse { return $this->crudShow($hogDailyRecord); }
    public function update(HogDailyRecordsRequest $request, HogDailyRecords $hogDailyRecord): JsonResponse { return $this->crudUpdate($hogDailyRecord, $request->validated()); }
    public function destroy(HogDailyRecords $hogDailyRecord): JsonResponse { return $this->crudDestroy($hogDailyRecord); }
}
