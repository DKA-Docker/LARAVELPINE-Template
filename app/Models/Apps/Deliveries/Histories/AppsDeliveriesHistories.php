<?php

namespace App\Models\Apps\Deliveries\Histories;

use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'name',
        'time_started',
        'time_received',
        'time_created',
    ];

    protected $with = ['account'];


    public function account(): BelongsTo
    {
        return $this->belongsTo(Accounts::class, 'account')->withDefault();
    }

}
