<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hogs extends Model
{
    use BelongsToUser, HasFactory;

    protected $table = 'hogs';

    protected $fillable = [
        'hog_pen_id',
        'ear_tag_id',
        'breed',
        'gender',
        'current_age',
        'weight_current',
    ];

    protected $casts = [
        'current_age' => 'integer',
        'weight_current' => 'decimal:2',
    ];

    public function hogPen(): BelongsTo
    {
        return $this->belongsTo(HogPens::class, 'hog_pen_id');
    }

    public function dailyRecords(): HasMany
    {
        return $this->hasMany(HogDailyRecords::class, 'hog_id');
    }
}
