<?php

namespace App\Models\Apps\Deliveries\Requests;

use App\Models\Apps\Deliveries\Requests\Destinations\AppsDeliveriesRequestsDestinations;
use App\Models\Apps\Deliveries\Requests\Destinations\Packages\AppsDeliveriesRequestsDestinationsPackages;
use App\Models\Base\Accounts\Accounts;
use Barryvdh\Debugbar\Facades\Debugbar;
use Database\Factories\Apps\Deliveries\Requests\AppsDeliveriesRequestsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesRequests extends Model {

    /** @use HasFactory<AppsDeliveriesRequestsFactory> */
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

    protected $with = ['account','destinations'];

    /**
     * Relation Data Account Untuk Table Ini Di dalam database
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Accounts::class, 'account')->withDefault();
    }

    /**
     * Satu Request punya banyak Packages
     * foreign key di tabel packages = request
     * local key di tabel ini = id
     *
     * @return HasMany
     */
    public function destinations(): HasMany
    {
        return $this->hasMany(
            AppsDeliveriesRequestsDestinations::class,
            'request',  // foreign key di tabel packages
            'id'        // local key di tabel requests
        );
    }




}
