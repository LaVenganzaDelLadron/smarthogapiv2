<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeederFeedTypeMapping extends Model
{
    use HasFactory;

    protected $table = 'feeder_feed_type_mapping';

    protected $fillable = [
        'feeder_id',
        'feed_type',
        'relay_pin',
        'max_duration_seconds',
        'is_active',
    ];

    protected $casts = [
        'relay_pin' => 'integer',
        'max_duration_seconds' => 'integer',
        'is_active' => 'boolean',
    ];

    public function feeder(): BelongsTo
    {
        return $this->belongsTo(Feeders::class, 'feeder_id');
    }
}
