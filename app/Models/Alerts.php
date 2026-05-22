<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alerts extends Model
{
    use HasFactory;

    protected $table = 'alerts';

    protected $fillable = [
        'farm_id',
        'hog_pen_id',
        'type',
        'message',
        'severity',
        'status',
    ];

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farms::class, 'farm_id');
    }

    public function hogPen(): BelongsTo
    {
        return $this->belongsTo(HogPens::class, 'hog_pen_id');
    }
}
