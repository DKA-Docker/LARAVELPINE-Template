<?php


namespace App\Models\Apps\Deliveries\Tasks\Routes;

use App\Models\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTasksRoutesOrigins;
use App\Models\Base\Accounts\Accounts;
use Database\Factories\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutesFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesTasksRoutes extends Model
{
    /** @use HasFactory<AppsDeliveriesTasksRoutesFactory> */
    use HasFactory, SoftDeletes, HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';


    /** Kolom yang bisa diisi */
    protected $fillable = [
        'id',
        'account',
    ];

    /** Cast tipe data */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $with = ['account','origin'];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Accounts::class, 'account')->withDefault();
    }

    public function origin(): BelongsTo
    {
        return $this->belongsTo(AppsDeliveriesTasksRoutesOrigins::class, 'id','route')->withDefault();
    }

}
