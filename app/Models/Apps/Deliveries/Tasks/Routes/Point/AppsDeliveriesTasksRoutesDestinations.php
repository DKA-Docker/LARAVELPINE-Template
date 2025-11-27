<?php

namespace App\Models\Apps\Deliveries\Tasks\Routes\Point;

use App\Models\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutes;
use Database\Factories\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutesFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|static inRandomOrder()
 */
class AppsDeliveriesTasksRoutesDestinations extends Model
{
    /** @use HasFactory<AppsDeliveriesTasksRoutesFactory> */
    use HasFactory, SoftDeletes, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'account',
        'route',
        'address',
        'longitude',
        'latitude',
        'image_received',
        'time_received',
    ];

    /** Cast tipe data */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(
            AppsDeliveriesTasksRoutes::class,
            'route',   // foreign key di tabel origins
            'id'       // primary key di tabel routes
        );
    }

}
