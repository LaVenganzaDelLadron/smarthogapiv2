<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceCommands extends Model
{
    use HasFactory;

    protected $table = 'device_commands';

    protected $fillable = [
        'iot_device_id',
        'action',
        'payload',
        'status',
        'executed_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'executed_at' => 'datetime',
    ];

    public function iotDevice(): BelongsTo
    {
        return $this->belongsTo(IotDevices::class, 'iot_device_id');
    }
}
