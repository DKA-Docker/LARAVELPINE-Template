<?php

namespace App\Models\Apps\Trackings\Monitors;

use Illuminate\Database\Eloquent\Model;

class AppsTrackingsMonitors extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    /** Kolom yang bisa diisi */
    protected $fillable = [
        'id',
        'account',
        'uuid',
        'latitude',
        'longitude',
        'speed',
        'created_at',
        'updated_at',
    ];
    /** Cast tipe data */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
