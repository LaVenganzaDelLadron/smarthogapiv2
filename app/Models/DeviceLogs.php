<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceLogs extends Model
{
    use BelongsToUser, HasFactory;

    protected $table = 'device_logs';

    protected $fillable = [
        'device_id',
        'action',
        'response',
    ];

    public function iotDevice(): BelongsTo
    {
        return $this->belongsTo(IotDevices::class, 'device_id');
    }
}
