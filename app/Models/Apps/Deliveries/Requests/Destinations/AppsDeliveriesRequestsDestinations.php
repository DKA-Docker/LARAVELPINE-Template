<?php
namespace App\Models\Apps\Deliveries\Requests\Destinations;

use App\Models\Apps\Deliveries\Requests\AppsDeliveriesRequests;
use App\Models\Apps\Deliveries\Requests\Destinations\Packages\AppsDeliveriesRequestsDestinationsPackages;
use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesRequestsDestinations extends Model {
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    /** Kolom yang bisa diisi */
    protected $fillable = [
        'id',
        'account',
        'request',
        'receipt_name',
        'receipt_address',
        'created_at',
        'updated_at',
    ];
    /** Cast tipe data */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $with = ['account','packages'];
//    protected $with = ['account'];

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
        return $this->belongsTo(AppsDeliveriesRequests::class, 'request')->withDefault();
    }

    public function packages(): HasMany
    {
        return $this->hasMany(AppsDeliveriesRequestsDestinationsPackages::class, 'destination','id' );
    }
}
