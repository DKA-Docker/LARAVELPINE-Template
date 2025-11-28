<?php

namespace App\Models\Apps\Deliveries\Tasks\Routes\Point\Packages;

use App\Models\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTasksRoutesDestinations;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesTasksRoutesDestinationsPackages extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'id',
        'account',
        'name',
        'qty',
        'unit',
        'destination',
        'note',
        'dimension_width',
        'dimension_height',
        'dimension_weigth',
        'heavy',
        'is_fragile',
    ];

    protected $with = ['destinations'];

    public function destinations(): HasMany
    {
        return $this->hasMany(AppsDeliveriesTasksRoutesDestinations::class, 'destination', 'id');
    }

}
