<?php

namespace App\Models\Apps\Deliveries\Tasks;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesTasksGeos extends Model
{
    use HasUuids, softDeletes;

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
