<?php

namespace App\Models\Base\Sessions;

use App\Models\Base\Accounts\Accounts;
use Database\Factories\Base\Sessions\SessionsAccountsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionsAccounts extends Model
{
    /** @use HasFactory<SessionsAccountsFactory> */
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'user_id',
        'user_agent',
        'ip_address',
        'last_activity',
    ];

    protected $hidden = [
        'id',
        'payload',
    ];

    protected $casts = [
        'last_activity' => 'integer',
    ];

    public function account()
    {
        return $this->belongsTo(Accounts::class);
    }
}
