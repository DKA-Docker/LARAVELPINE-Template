<?php

namespace App\Models\Base\Permissions;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PermissionsRole extends SpatieRole
{
    use HasUuids;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    // Tambahkan ini jika error "id = 0" masih muncul
    public function getKeyType(): string
    {
        return 'string';
    }
}
