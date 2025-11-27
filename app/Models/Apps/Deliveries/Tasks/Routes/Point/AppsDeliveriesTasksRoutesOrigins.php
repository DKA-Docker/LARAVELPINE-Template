<?php

namespace App\Models\Apps\Deliveries\Tasks\Routes\Point;

use App\Models\Apps\Deliveries\Tasks\Routes\AppsDeliveriesTasksRoutes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesTasksRoutesOrigins extends Model {
    use HasUuids, HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    /** Kolom yang bisa diisi */
    protected $fillable = [
        'id',
        'account',
        'route',
        'address',
        'latitude',
        'longitude',
        'seq',
        'image_picked',
        'time_picked'
    ];

    /** Cast tipe data */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(
            AppsDeliveriesTasksRoutes::class,
            'route',   // foreign key di tabel origins
            'id'       // primary key di tabel routes
        );
    }
}
