<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebHookLogs extends Model
{
    use BelongsToUser, HasFactory;

    protected $table = 'webhook_logs';

    protected $fillable = [
        'url',
        'event',
        'payload',
        'status',
        'error',
        'farm_id',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farms::class, 'farm_id');
    }
}
