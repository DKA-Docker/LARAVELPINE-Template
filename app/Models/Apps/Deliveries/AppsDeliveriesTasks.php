<?php

namespace App\Models\Apps\Deliveries;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppsDeliveriesTasks extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
}
