<?php

namespace App\Models\Apps\Deliveries\Histories;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesHistories extends Model
{
    use  HasUuids, HasFactory ,SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'apps_deliveries_histories';

    protected $fillable = [
        'task',
        'account',
        'to_status',
        'title',
        'description',
        'name'
    ];

}
