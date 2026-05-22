<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PredictionCache extends Model
{
    use HasFactory;

    protected $table = 'prediction_cache';

    protected $fillable = [
        'prediction_type',
        'pen_id',
        'cache_key',
        'data',
        'expires_at',
    ];

    protected $casts = [
        'data' => 'array',
        'expires_at' => 'datetime',
    ];

    public function hogPen(): BelongsTo
    {
        return $this->belongsTo(HogPens::class, 'pen_id');
    }
}
