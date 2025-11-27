<?php


namespace App\Models\Apps\Deliveries\Tasks\Routes;

use App\Models\Apps\Deliveries\Tasks\Routes\Point\AppsDeliveriesTaskRoutesOrigin;
use Database\Factories\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutesFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesTasksRoutes extends Model
{
    /** @use HasFactory<AppsDeliveriesTasksRoutesFactory> */
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';


    /** Kolom yang bisa diisi */
    protected $fillable = [
        'id',
        'account',
        'time_created',
        'time_updated',
    ];

    /** Cast tipe data */
    protected $casts = [
        'time_created' => 'datetime',
        'time_updated' => 'datetime',
    ];

    public function origin()
    {
        return $this->hasOne(AppsDeliveriesTaskRoutesOrigin::class, 'route');
    }

}
