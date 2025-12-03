<?php

namespace App\Models\Apps\Deliveries\Requests\Destinations\Packages;

use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use App\Models\Apps\Deliveries\Requests\Destinations\Packages\Units\AppsDeliveriesRequestsDestinationsPackagesUnits;
use App\Models\Base\Accounts\Accounts;
use Database\Factories\Apps\Deliveries\Requests\Destinations\Packages\AppsDeliveriesRequestsDestinationsPackagesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesRequestsDestinationsPackages extends Model
{
    /** @use HasFactory<AppsDeliveriesRequestsDestinationsPackagesFactory> */
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    /** Kolom yang bisa diisi */
    protected $fillable = [
        'id',
        'destination',
        'account',
        'name',
        'qty',
        'unit',
        'note',
        'width',
        'height',
        'weight',
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
        return $this->BelongsTo(AppsDeliveriesRequestsDestinationsPackagesUnits::class, 'unit','id')->withDefault();
    }

}
