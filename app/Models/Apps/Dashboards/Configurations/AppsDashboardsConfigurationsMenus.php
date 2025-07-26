<?php

namespace App\Models\Apps\Dashboards\Configurations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppsDashboardsConfigurationsMenus extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'type',
        'name',
        'icon',
        'routes'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(AppsDashboardsConfigurationsMenus::class, 'parent', 'id');
    }
}
