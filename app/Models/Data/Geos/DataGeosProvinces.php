<?php

namespace App\Models\Data\Geos;

use Database\Factories\Apps\Trackings\Monitors\AppsTrackingsMonitorsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataGeosProvinces extends Model
{

    /** Kolom yang bisa diisi */
    protected $fillable = [
        'id',
        'name',
    ];
}
