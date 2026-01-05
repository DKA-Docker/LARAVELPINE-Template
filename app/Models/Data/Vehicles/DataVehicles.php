<?php

namespace App\Models\Data\Vehicles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DataVehicles extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'category',
        'name',
        'plate',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(DataVehicleCategories::class, 'category');
    }
}
