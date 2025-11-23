<?php

namespace App\Models\Apps\Deliveries;

use Database\Factories\Apps\Deliveries\Requests\AppsDeliveriesRequestsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesRequests extends Model {

    /** @use HasFactory<AppsDeliveriesRequestsFactory> */
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';


}
