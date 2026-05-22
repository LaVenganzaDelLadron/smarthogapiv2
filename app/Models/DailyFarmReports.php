<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyFarmReports extends Model
{
    use HasFactory;

    protected $table = 'daily_farm_reports';

    protected $fillable = [
        'farm_id',
        'total_feed_consumed',
        'total_hogs',
        'avg_weight',
        'mortality_count',
        'report_date',
        'active_pens',
        'avg_temperature',
        'avg_humidity',
        'alerts_triggered',
        'sick_hogs',
        'avg_weekly_weight_gain',
    ];

    protected $casts = [
        'total_feed_consumed' => 'decimal:2',
        'total_hogs' => 'integer',
        'avg_weight' => 'decimal:2',
        'mortality_count' => 'decimal:2',
        'report_date' => 'datetime',
        'active_pens' => 'integer',
        'avg_temperature' => 'decimal:2',
        'avg_humidity' => 'decimal:2',
        'alerts_triggered' => 'integer',
        'sick_hogs' => 'integer',
        'avg_weekly_weight_gain' => 'decimal:2',
    ];

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farms::class, 'farm_id');
    }
}
