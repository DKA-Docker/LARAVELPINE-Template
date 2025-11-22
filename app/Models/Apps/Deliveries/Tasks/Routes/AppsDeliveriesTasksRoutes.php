<?php

namespace App\Models\Apps\Deliveries\Tasks\Routes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppsDeliveriesTasksRoutes extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    /** Cast tipe data */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
