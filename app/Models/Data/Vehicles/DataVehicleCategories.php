<?php

namespace App\Models\Data\Vehicles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DataVehicleCategories extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'name',
        'description'
    ];
}
