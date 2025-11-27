<?php

namespace App\Models\Apps\Deliveries\Tasks\Routes\Point;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesTaskRoutesDestination extends Model
{
    use SoftDeletes, HasUuids, HasFactory;

    protected $table = 'apps_deliveries_task_routes_destinations';

    protected $fillable = [
        'account',
        'route',
        'address',
        'longitude',
        'latitude',
        'image_received',
        'time_received',
        'time_created',
        'time_updated'
    ];

    /** Cast tipe data */
    protected $casts = [
        'time_created' => 'datetime',
        'time_updated' => 'datetime',
    ];

}
