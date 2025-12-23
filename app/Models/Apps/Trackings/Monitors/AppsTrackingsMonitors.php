<?php

namespace App\Models\Apps\Trackings\Monitors;

use App\Models\Base\Accounts\Accounts;
use Database\Factories\Apps\Trackings\Monitors\AppsTrackingsMonitorsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsTrackingsMonitors extends Model
{
    /**
     * @use HasFactory<AppsTrackingsMonitorsFactory>
     */
    use HasFactory, SoftDeletes;
    public $incrementing = false;
    protected $keyType = 'string';

    /** Kolom yang bisa diisi */
    protected $fillable = [
        'id',
        'account',
        'latitude',
        'longitude',
        'speed',
        'created_at',
        'updated_at',
    ];
    /** Cast tipe data */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $with = ['account'];

    /**
     * Relation Data Account Untuk Table Ini Di dalam database
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Accounts::class, 'account')->withDefault();
    }

}
