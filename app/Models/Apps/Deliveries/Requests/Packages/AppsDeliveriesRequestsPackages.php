<?php

namespace App\Models\Apps\Deliveries\Requests\Packages;

use App\Models\Base\Accounts\Accounts;
use Database\Factories\Apps\Deliveries\Requests\Packages\AppsDeliveriesRequestsPackagesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    /**
     * Relation Data Account Untuk Table Ini Di dalam database
     * @return HasOne
     */
    public function account(): HasOne
    {
        return $this->hasOne(Accounts::class, 'account')->withDefault();
    }

    public function request(): HasOne
    {
        return $this->hasOne(AppsDeliveriesRequestsPackages::class, 'request')->withDefault();
    }

}
