<?php

namespace App\Models\Apps\Deliveries\Tasks\Routes\Point;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesTaskRoutesOrigin extends Model {
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    /** Kolom yang bisa diisi */
    protected $fillable = [
        'id',
        'account',
        'created_at',
        'updated_at',
    ];

    /** Cast tipe data */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
