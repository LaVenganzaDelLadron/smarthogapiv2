<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SensorReadings extends Model
{
    use HasFactory;

    protected $table = 'sensor_readings';

    protected $fillable = [
        'sensor_id',
        'value',
        'unit',
    ];

    protected $casts = [
        'value' => 'decimal:2',
    ];

    public function sensor(): BelongsTo
    {
        return $this->belongsTo(Sensors::class, 'sensor_id');
    }
}
