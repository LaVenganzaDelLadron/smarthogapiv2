<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Concerns\HandlesCrud;
use App\Http\Controllers\Controller;
use App\Http\Requests\HogsRequest;
use App\Http\Resources\HogResource;
use App\Models\HogPens;
use App\Models\Hogs;
use Illuminate\Http\JsonResponse;

class HogsController extends Controller
{
    use HandlesCrud;

    protected function modelClass(): string { return Hogs::class; }
    protected function resourceClass(): string { return HogResource::class; }
    protected function relationships(): array { return ['hogPen']; }
    protected function ownedParentFields(): array { return ['hog_pen_id' => HogPens::class]; }

    public function index(): JsonResponse { return $this->crudIndex(); }
    public function store(HogsRequest $request): JsonResponse { return $this->crudStore($request->validated()); }
    public function show(Hogs $hog): JsonResponse { return $this->crudShow($hog); }
    public function update(HogsRequest $request, Hogs $hog): JsonResponse { return $this->crudUpdate($hog, $request->validated()); }
    public function destroy(Hogs $hog): JsonResponse { return $this->crudDestroy($hog); }
}
