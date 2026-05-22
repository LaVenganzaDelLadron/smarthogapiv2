<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MlModels extends Model
{
    use HasFactory;

    protected $table = 'ml_models';

    protected $fillable = [
        'model_name',
        'version',
        'accuracy_score',
    ];

    protected $casts = [
        'accuracy_score' => 'decimal:2',
    ];

    public function feedingPredictions(): HasMany
    {
        return $this->hasMany(FeedingPredictions::class, 'ml_model_id');
    }
}
