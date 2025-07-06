<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class AccountsCredentials extends Authenticatable
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

    public function account()
    {
        return $this->hasOne(Accounts::class, 'credential', 'id');
    }

    public function getAuthIdentifier()
    {
        // pastikan sudah ada relasi account()
        return $this->account?->id ?? $this->id;
    }
}
