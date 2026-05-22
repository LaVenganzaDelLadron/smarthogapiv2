<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sensors extends Model
{
    use HasFactory;

    protected $table = 'sensors';

    protected $fillable = [
        'hog_pen_id',
        'sensor_type',
        'device_id',
        'status',
    ];

    public function hogPen(): BelongsTo
    {
        return $this->belongsTo(HogPens::class, 'hog_pen_id');
    }

    public function iotDevice(): BelongsTo
    {
        return $this->belongsTo(IotDevices::class, 'device_id');
    }

    public function sensorReadings(): HasMany
    {
        return $this->hasMany(SensorReadings::class, 'sensor_id');
    }
}
