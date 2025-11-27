<?php

namespace App\Models\Apps\Deliveries\Tasks\Routes\Point;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesTaskRoutesOrigin extends Model {
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $table = 'apps_deliveries_tasks_routes_origin';

    /** Kolom yang bisa diisi */
    protected $fillable = [
        'id',
        'account',
        'time_created',
        'time_updated',
    ];

    /** Cast tipe data */
    protected $casts = [
        'time_created' => 'datetime',
        'time_updated' => 'datetime',
    ];
}
