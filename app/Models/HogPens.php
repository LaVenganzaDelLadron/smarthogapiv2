<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HogPens extends Model
{
    use HasFactory;

    protected $table = 'hog_pens';

    protected $fillable = [
        'farm_id',
        'name',
        'capacity',
        'status',
        'external_provider',
        'external_room_id',
        'external_metadata',
    ];

    protected $casts = [
        'capacity' => 'integer',
        'status' => 'integer',
        'external_metadata' => 'array',
    ];

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farms::class, 'farm_id');
    }

    public function hogs(): HasMany
    {
        return $this->hasMany(Hogs::class, 'hog_pen_id');
    }

    public function hogDailyRecords(): HasMany
    {
        return $this->hasMany(HogDailyRecords::class, 'hog_pen_id');
    }

    public function alerts(): HasMany
    {
        return $this->hasMany(Alerts::class, 'hog_pen_id');
    }

    public function iotDevices(): HasMany
    {
        return $this->hasMany(IotDevices::class, 'hog_pen_id');
    }

    public function feeders(): HasMany
    {
        return $this->hasMany(Feeders::class, 'hog_pen_id');
    }

    public function feedingQueue(): HasMany
    {
        return $this->hasMany(FeedingQueue::class, 'hog_pen_id');
    }

    public function feedingSchedule(): HasMany
    {
        return $this->hasMany(FeedingSchedule::class, 'hog_pen_id');
    }

    public function feedingPredictions(): HasMany
    {
        return $this->hasMany(FeedingPredictions::class, 'hog_pen_id');
    }

    public function predictionCaches(): HasMany
    {
        return $this->hasMany(PredictionCache::class, 'pen_id');
    }

    public function sensors(): HasMany
    {
        return $this->hasMany(Sensors::class, 'hog_pen_id');
    }
}
