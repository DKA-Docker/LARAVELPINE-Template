<?php

namespace App\Models\Apps\Deliveries\Tasks;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesTasksGeos extends Model
{
    use HasUuids, softDeletes;

    // Nama tabel sesuai migration yang kita buat sebelumnya
    protected $table = 'apps_deliveries_tasks_geos';

    protected $fillable = [
        'task',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude'=> 'float',
        'longitude'=> 'float',
    ];


}
