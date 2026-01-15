<?php

namespace App\Models\Apps\Deliveries\Tasks;

use App\Models\Apps\Deliveries\Histories\AppsDeliveriesHistories;
use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use App\Models\Apps\Deliveries\Requests\Destinations\AppsDeliveriesRequestsDestinations;
use App\Models\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutes;
use App\Models\Base\Accounts\Accounts;
use Database\Factories\Apps\Deliveries\Tasks\AppsDeliveriesTasksFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class AppsDeliveriesTasks extends Model
{
    /** @use HasFactory<AppsDeliveriesTasksFactory> */
    use HasUuids, HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    /** Kolom yang bisa diisi */
    protected $fillable = [
        'id',
        'account',
        'name', // keterangan
        'destination',
        'vehicle' // kendaraan
    ];

    protected $with = ['account','assigned', 'destination', 'history','geos'];

    protected $hidden = [
        'deleted_at',
    ];
    /**
     * Relation Data Account Untuk Table Ini Di dalam database
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Accounts::class, 'account')->withDefault();
    }

    public function history(): HasMany
    {
        return $this->hasMany(
            AppsDeliveriesHistories::class,
            'task',   // FK di histories
            'id'      // PK tasks
        );
    }

    public function assigned(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Accounts::class,                  // related model
            table: 'apps_deliveries_tasks_assigns',   // pivot table
            foreignPivotKey: 'task',                         // FK ke tasks
            relatedPivotKey: 'account',                      // FK ke accounts
            parentKey: 'id',                              // PK tasks
            relatedKey: 'id'                               // PK accounts
        );
    }


    public function destination(): BelongsTo
    {
        return $this->belongsTo(AppsDeliveriesRequestsDestinations::class, 'destination')->withTrashed()->withDefault();
    }

    public function assigns(): HasMany
    {
        return $this->hasMany(AppsDeliveriesTasksAssigns::class, 'task', 'id');
    }

    public function geos(): HasOne
    {
        return $this->hasOne(AppsDeliveriesTasksGeos::class, 'task', // Foreign Key di tabel geos (sesuai migration sebelumnya)
            'id' // Local Key di tabel tasks
        )->withDefault();
    }
    public function sessions(): HasMany
    {
        return $this->hasMany(
            \App\Models\Apps\Deliveries\Tasks\Sessions\AppsDeliveriesTasksSessions::class,
            'task',
            'id'
        );
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(
            \App\Models\Apps\Deliveries\Tasks\Attachments\AppsDeliveriesTasksAttachments::class,
            'task_id',
            'id'
        );
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Data\Vehicles\DataVehicles::class, 'vehicle')->withDefault();
    }
}
