<?php

namespace App\Models\Data\Geos;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataGeosVillages extends Model
{

    use HasFactory;
    protected $fillable = [
        'id',
        'district_id',
        'name',
    ];
}
