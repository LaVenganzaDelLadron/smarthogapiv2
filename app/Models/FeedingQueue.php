<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedingQueue extends Model
{
    use BelongsToUser, HasFactory;

    protected $table = 'feeding_queue';

    protected $fillable = [
        'feeder_id',
        'hog_pen_id',
        'feed_type',
        'scheduled_at',
        'actual_feed_time',
        'status',
        'duration_seconds',
        'amount_dispensed',
        'error_message',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'actual_feed_time' => 'datetime',
        'duration_seconds' => 'integer',
        'amount_dispensed' => 'decimal:2',
    ];

    public function feeder(): BelongsTo
    {
        return $this->belongsTo(Feeders::class, 'feeder_id');
    }

    public function hogPen(): BelongsTo
    {
        return $this->belongsTo(HogPens::class, 'hog_pen_id');
    }
}
