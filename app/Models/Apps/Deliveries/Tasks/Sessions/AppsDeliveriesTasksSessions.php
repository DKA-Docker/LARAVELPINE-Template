<?php

namespace App\Models\Apps\Deliveries\Tasks\Sessions;

use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesTasksSessions extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'apps_deliveries_tasks_sessions';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'account',
        'task',
        'route',
        'description',
        'time_started',
        'time_received',
        'time_created',
    ];

    protected $with = ['accountDetail','taskDetail'];

    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Relation Data Account Untuk Table Ini Di dalam database
     * @return BelongsTo
     */
    public function accountDetail(): BelongsTo
    {
        return $this->belongsTo(Accounts::class, 'account')->withDefault();
    }

    public function taskDetail(): BelongsTo
    {
        return $this->belongsTo(AppsDeliveriesTasks::class, 'task');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->route)) {
                $model->route = DB::raw("ST_GeomFromText('LINESTRINGZM EMPTY', 4326)");
            }
        });
    }
}
