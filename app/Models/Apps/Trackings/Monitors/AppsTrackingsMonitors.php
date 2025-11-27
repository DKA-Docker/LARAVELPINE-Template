<?php

namespace App\Models\Apps\Trackings\Monitors;

use Database\Factories\Apps\Trackings\Monitors\AppsTrackingsMonitorsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsTrackingsMonitors extends Model
{
    /**
     * @use HasFactory<AppsTrackingsMonitorsFactory>
     */
    use HasFactory, SoftDeletes;
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
