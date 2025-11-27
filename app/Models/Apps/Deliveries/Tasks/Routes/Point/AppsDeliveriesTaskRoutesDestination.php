<?php

namespace App\Models\Apps\Deliveries\Tasks\Routes\Point;

use Database\Factories\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutesFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|static inRandomOrder()
 */
class AppsDeliveriesTaskRoutesDestination extends Model
{
    /** @use HasFactory<AppsDeliveriesTasksRoutesFactory> */
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'apps_deliveries_tasks_routes_destinations';

    protected $fillable = [
        'id',
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
