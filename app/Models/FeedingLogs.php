<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedingLogs extends Model
{
    use BelongsToUser, HasFactory;

    protected $table = 'feeding_logs';

    protected $fillable = [
        'feeder_id',
        'pen_id',
        'feed_amount_given',
        'triggered',
    ];

    protected $casts = [
        'feed_amount_given' => 'decimal:2',
    ];

    public function feeder(): BelongsTo
    {
        return $this->belongsTo(Feeders::class, 'feeder_id');
    }

    public function hogPen(): BelongsTo
    {
        return $this->belongsTo(HogPens::class, 'pen_id');
    }
}
