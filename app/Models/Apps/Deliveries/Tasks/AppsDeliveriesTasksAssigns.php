<?php

namespace App\Models\Apps\Deliveries\Tasks;

use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use App\Models\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutes;
use App\Models\Base\Accounts\Accounts;
use Database\Factories\Apps\Deliveries\Tasks\AppsDeliveriesTasksFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class AppsDeliveriesTasksAssigns extends Model
{
    /** @use HasFactory<AppsDeliveriesTasksFactory> */
    use HasUuids, HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    /** Kolom yang bisa diisi */
    protected $fillable = [
        'id',
        'account',
        'task'
    ];

    protected $with = ['assignedAccount','taskData'];

    protected $hidden = ['pivot'];

    /**
     * Relation Data Account Untuk Table Ini Di dalam database
     * @return BelongsTo
     */
    public function assignedAccount(): BelongsTo
    {
        return $this->belongsTo(Accounts::class, 'account')->withDefault();
    }

    public function taskData(): BelongsTo
    {
        return $this->belongsTo(AppsDeliveriesTasks::class, 'task')->withDefault();
    }

    /*public function request(): BelongsTo
    {
        return $this->belongsTo(AppsDeliveriesRequests::class, 'request')->withDefault();
    }*/


}
