<?php

namespace App\Models\Data\Geos;

use Illuminate\Database\Eloquent\Model;

class DataGeosRegencies extends Model
{

    protected $fillable = [
        'id',
        'province_id',
        'name'
    ];
}
