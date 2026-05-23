<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\DailyFarmReportsRequest;
use App\Http\Resources\DailyFarmReportResource;
use App\Models\DailyFarmReports;
use App\Models\Farms;
use Illuminate\Http\JsonResponse;

class DailyFarmReportsController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return DailyFarmReports::class; }
    protected function resourceClass(): string { return DailyFarmReportResource::class; }
    protected function relationships(): array { return ['farm']; }
    protected function ownedParentFields(): array { return ['farm_id' => Farms::class]; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(DailyFarmReportsRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(DailyFarmReports $dailyFarmReport): JsonResponse { return $this->crudShow($dailyFarmReport); }
    public function update(DailyFarmReportsRequest $request, DailyFarmReports $dailyFarmReport): JsonResponse { return $this->crudUpdate($dailyFarmReport, $request->validated()); }
    public function destroy(DailyFarmReports $dailyFarmReport): JsonResponse { return $this->crudDestroy($dailyFarmReport); }
}
