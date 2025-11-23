<?php

namespace App\Models\Apps\Deliveries\Tasks;

use App\Models\Base\Accounts\Accounts;
use Database\Factories\Apps\Deliveries\Tasks\AppsDeliveriesTasksFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;

class AppsDeliveriesTasks extends Model
{
    /** @use HasFactory<AppsDeliveriesTasksFactory> */
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    /** Kolom yang bisa diisi */
    protected $fillable = [
        'id',
        'account',
        'name',
        'assigned',
        'route',
        'created_at',
        'updated_at',
    ];
    /** Cast tipe data */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function account(): HasOne
    {
        return $this->hasOne(Accounts::class, 'account')->withDefault();
    }


}
