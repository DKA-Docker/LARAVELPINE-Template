<?php

namespace App\Models\Accounts\Components;

use App\Models\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class AccountsCredentials extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'username',
        'password',
    ];

    protected $hidden = [
        'id',
        'password',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Auto-hash password on set
     */
    public function setPasswordAttribute($value)
    {
        // Cegah double hash jika sudah hashed (misalnya dari seeder atau testing)
        $this->attributes['password'] = Hash::needsRehash($value)
            ? Hash::make($value)
            : $value;
    }

    public function account(): HasOne
    {
        return $this->hasOne(Accounts::class, 'credential', 'id');
    }
}
