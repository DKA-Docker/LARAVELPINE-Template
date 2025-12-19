<?php

namespace App\Models\Data\Geos;

use Illuminate\Database\Eloquent\Model;

class DataGeosVillages extends Model
{
    protected $fillable = [
        'id',
        'district_id',
        'name',
    ];
}
