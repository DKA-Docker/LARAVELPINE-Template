<?php

namespace App\Models;

use Database\Factories\SessionsAccountsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionsAccounts extends Model
{
    /** @use HasFactory<SessionsAccountsFactory> */
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'account',
        'session',
        'user_agent',
        'ip_address',
        'last_active_at',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'last_active_at' => 'datetime',
    ];

    public function account()
    {
        return $this->belongsTo(Accounts::class);
    }
}
