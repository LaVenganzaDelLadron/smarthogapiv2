<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feeders extends Model
{
    use BelongsToUser, HasFactory;

    protected $table = 'feeders';

    protected $fillable = [
        'hog_pen_id',
        'device_id',
        'status',
        'last_refill',
    ];

    protected $casts = [
        'last_refill' => 'datetime',
    ];

    public function hogPen(): BelongsTo
    {
        return $this->belongsTo(HogPens::class, 'hog_pen_id');
    }

    public function iotDevice(): BelongsTo
    {
        return $this->belongsTo(IotDevices::class, 'device_id');
    }

    public function feedTypeMappings(): HasMany
    {
        return $this->hasMany(FeederFeedTypeMapping::class, 'feeder_id');
    }

    public function feedingLogs(): HasMany
    {
        return $this->hasMany(FeedingLogs::class, 'feeder_id');
    }

    public function feedingQueue(): HasMany
    {
        return $this->hasMany(FeedingQueue::class, 'feeder_id');
    }
}
