<?php


namespace App\Models\Apps\Deliveries\Tasks\Routes;

use Database\Factories\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutesFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesTasksRoutes extends Model
{
    /** @use HasFactory<AppsDeliveriesTasksRoutesFactory> */
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    /** Kolom yang bisa diisi */
    protected $fillable = [
//        'id',
        'account',
        'time_created',
        'time_updated',
        'time_deleted'
    ];

    /** Cast tipe data */
    protected $casts = [
        'time_created' => 'datetime',
        'time_updated' => 'datetime',
        'time_deleted' => 'datetime'
    ];
}
