<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Farms extends Model
{
    use HasFactory;

    protected $table = 'farms';

    protected $fillable = [
        'user_id',
        'location',
        'timezone',
        'external_provider',
        'external_home_id',
        'external_metadata',
    ];

    protected $casts = [
        'external_metadata' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hogPens(): HasMany
    {
        return $this->hasMany(HogPens::class, 'farm_id');
    }

    public function dailyFarmReports(): HasMany
    {
        return $this->hasMany(DailyFarmReports::class, 'farm_id');
    }

    public function webhookLogs(): HasMany
    {
        return $this->hasMany(WebHookLogs::class, 'farm_id');
    }

    public function alerts(): HasMany
    {
        return $this->hasMany(Alerts::class, 'farm_id');
    }
}
