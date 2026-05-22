<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceCredentials extends Model
{
    use HasFactory;

    protected $table = 'device_credentials';

    protected $fillable = [
        'user_id',
        'iot_device_id',
        'name',
        'api_key',
        'secret',
        'abilities',
        'last_used_at',
        'revoked_at',
    ];

    protected $hidden = [
        'api_key',
        'secret',
    ];

    protected $casts = [
        'abilities' => 'array',
        'last_used_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function iotDevice(): BelongsTo
    {
        return $this->belongsTo(IotDevices::class, 'iot_device_id');
    }
}
