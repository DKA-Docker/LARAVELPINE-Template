<?php

namespace App\Models\Base\Permissions;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Permissions extends SpatiePermission
{
    use HasUuids;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    public function getKeyType(): string
    {
        return 'string';
    }
}
