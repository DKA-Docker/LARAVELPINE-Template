<?php

namespace App\Models\Apps\Deliveries\Rates;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesDataRatesCategories extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'apps_deliveries_data_rates_categories';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'icon',
        'description',
    ];
}
