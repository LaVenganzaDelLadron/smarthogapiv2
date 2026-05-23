<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedingPredictions extends Model
{
    use BelongsToUser, HasFactory;

    protected $table = 'feeding_predictions';

    protected $fillable = [
        'hog_pen_id',
        'ml_model_id',
        'predicted_feed_amount',
        'confidence_score',
        'model_used',
        'confidence_level',
        'confidence_reason',
        'feed_recommendation',
        'feed_totals',
        'weight_trend',
        'pen_status',
        'warnings',
        'alerts',
        'suggestions',
        'fastapi_response',
        'predicted_at',
    ];

    protected $casts = [
        'predicted_feed_amount' => 'decimal:2',
        'confidence_score' => 'decimal:2',
        'feed_recommendation' => 'array',
        'feed_totals' => 'array',
        'weight_trend' => 'array',
        'pen_status' => 'array',
        'warnings' => 'array',
        'alerts' => 'array',
        'suggestions' => 'array',
        'fastapi_response' => 'array',
        'predicted_at' => 'datetime',
    ];

    public function hogPen(): BelongsTo
    {
        return $this->belongsTo(HogPens::class, 'hog_pen_id');
    }

    public function mlModel(): BelongsTo
    {
        return $this->belongsTo(MlModels::class, 'ml_model_id');
    }
}
