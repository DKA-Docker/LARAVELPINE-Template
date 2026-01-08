<?php

namespace App\Models\Apps\Deliveries\Rates;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppsDeliveriesDataRates extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'apps_deliveries_data_rates';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'price',
        'category',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function category_rel(): BelongsTo
    {
        return $this->belongsTo(AppsDeliveriesDataRatesCategories::class, 'category', 'id');
    }
}
