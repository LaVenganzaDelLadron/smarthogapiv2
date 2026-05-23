<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HogDailyRecords extends Model
{
    use BelongsToUser, HasFactory;

    protected $table = 'hog_daily_records';

    protected $fillable = [
        'hog_id',
        'hog_pen_id',
        'weight',
        'feed_consumed',
        'health_status',
        'temperature',
        'activity_level',
        'notes',
        'recorded_date',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'feed_consumed' => 'decimal:2',
        'temperature' => 'decimal:2',
        'recorded_date' => 'datetime',
    ];

    public function hog(): BelongsTo
    {
        return $this->belongsTo(Hogs::class, 'hog_id');
    }

    public function hogPen(): BelongsTo
    {
        return $this->belongsTo(HogPens::class, 'hog_pen_id');
    }
}
