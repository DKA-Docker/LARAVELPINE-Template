<?php

namespace App\Models\Apps\Deliveries\Requests\Packages;

use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use App\Models\Apps\Deliveries\Requests\Packages\Units\AppsDeliveriesRequestsPackagesUnits;
use App\Models\Base\Accounts\Accounts;
use Database\Factories\Apps\Deliveries\Requests\Packages\AppsDeliveriesRequestsPackagesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesRequestsPackages extends Model
{
    /** @use HasFactory<AppsDeliveriesRequestsPackagesFactory> */
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    /** Kolom yang bisa diisi */
    protected $fillable = [
        'id',
        'request',
        'account',
        'name',
        'qty',
        'unit',
        'note',
        'dimension_width',
        'dimension_height',
        'dimension_weigth',
        'heavy',
        'is_fragile',
        'created_at',
        'updated_at',
    ];
    /** Cast tipe data */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $with = ['account','unit'];

    /**
     * Relation Data Account Untuk Table Ini Di dalam database
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Accounts::class, 'account')->withDefault();
    }

    public function request(): BelongsTo
    {
        return $this->BelongsTo(AppsDeliveriesRequests::class, 'request','id')->withDefault();
    }

    public function unit(): BelongsTo
    {
        return $this->BelongsTo(AppsDeliveriesRequestsPackagesUnits::class, 'unit','id')->withDefault();
    }

}
