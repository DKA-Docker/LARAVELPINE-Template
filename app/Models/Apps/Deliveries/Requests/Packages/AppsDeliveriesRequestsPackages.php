<?php

namespace App\Models\Apps\Deliveries\Requests\Packages;

use Database\Factories\Apps\Deliveries\Requests\Packages\AppsDeliveriesRequestsPackagesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'account',
        'name',
        'created_at',
        'updated_at',
    ];
    /** Cast tipe data */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
