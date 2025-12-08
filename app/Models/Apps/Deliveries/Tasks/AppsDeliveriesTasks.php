<?php

namespace App\Models\Apps\Deliveries\Tasks;

use App\Models\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutes;
use App\Models\Base\Accounts\Accounts;
use Database\Factories\Apps\Deliveries\Tasks\AppsDeliveriesTasksFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'assigned', // array [] => hasMANY ke tabel akun
        'history', // to do, checking , delivery,
    ];

    protected $with = ['account','assigned','route'];

    /**
     * Relation Data Account Untuk Table Ini Di dalam database
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Accounts::class, 'account')->withDefault();
    }

    public function assigned(): BelongsTo
    {
        return $this->belongsTo(Accounts::class, 'account')->withDefault();
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(AppsDeliveriesTasksRoutes::class, 'route')->withDefault();
    }




}
