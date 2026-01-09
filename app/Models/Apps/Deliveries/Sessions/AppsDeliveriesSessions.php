<?php

namespace App\Models\Apps\Deliveries\Sessions;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesSessions extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'apps_deliveries_sessions';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        // No additional columns in migration currently
    ];
}
