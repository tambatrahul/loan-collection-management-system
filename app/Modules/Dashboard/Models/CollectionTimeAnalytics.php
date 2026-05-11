<?php

namespace App\Modules\Dashboard\Models;

use Illuminate\Database\Eloquent\Model;

final class CollectionTimeAnalytics extends Model
{
    protected $table = 'collection_time_analytics';

    protected $fillable = [
        'user_id',
        'analytics_date',
        'slot_start_hour',
        'total_collections',
        'total_amount',
        'last_refreshed_at',
    ];

    protected $casts = [
        'analytics_date' => 'date',
        'total_amount' => 'decimal:2',
        'last_refreshed_at' => 'datetime',
    ];
}