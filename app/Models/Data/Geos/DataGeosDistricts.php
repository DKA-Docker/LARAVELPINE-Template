<?php

namespace App\Models\Data\Geos;

use Illuminate\Database\Eloquent\Model;

class DataGeosDistricts extends Model
{
    protected $fillable = [
        'id',
        'regency_id',
        'name',
    ];
}
