<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToUser
{
    public function scopeOwnedByUser(Builder $query, int $userId): Builder
    {
        $relationPath = $this->ownerRelationPath();

        if ($relationPath === 'self') {
            return $query->where('user_id', $userId);
        }

        if ($relationPath === null) {
            return $query;
        }

        return $query->whereHas($relationPath, fn (Builder $query) => $query->where('user_id', $userId));
    }

    public function belongsToUser(int $userId): bool
    {
        $relationPath = $this->ownerRelationPath();

        if ($relationPath === 'self') {
            return (int) $this->getAttribute('user_id') === $userId;
        }

        if ($relationPath === null) {
            return false;
        }

        return static::query()
            ->whereKey($this->getKey())
            ->ownedByUser($userId)
            ->exists();
    }

    protected function ownerRelationPath(): ?string
    {
        if (array_key_exists('user_id', $this->getAttributes()) || in_array('user_id', $this->getFillable(), true)) {
            return 'self';
        }

        foreach (['farm', 'hogPen.farm', 'hog.hogPen.farm', 'sensor.hogPen.farm', 'feeder.hogPen.farm', 'iotDevice.hogPen.farm'] as $path) {
            $method = str($path)->before('.')->toString();

            if (method_exists($this, $method)) {
                return $path;
            }
        }

        return null;
    }
}
