<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Accounts extends Authenticatable
{
    use HasFactory, Notifiable;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'information',
        'credential',
        'contact',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'remember_token',
        'deleted_at'
    ];

    // Relasi ke info
    public function info(): HasOne
    {
        return $this->hasOne(AccountsInformations::class, 'id', 'information');
    }

    // Relasi ke credential
    public function credential(): HasOne
    {
        return $this->hasOne(AccountsCredentials::class, 'id', 'credential');
    }

    public function contact(): HasOne
    {
        return $this->hasOne(AccountsContacts::class, 'id', 'contact');
    }
}
