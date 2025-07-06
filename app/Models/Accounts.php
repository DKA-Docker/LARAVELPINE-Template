<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Accounts extends Model
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
    public function information(): BelongsTo
    {
        return $this->belongsTo(AccountsInformations::class, 'information');
    }
    public function credential(): BelongsTo
    {
        return $this->belongsTo(AccountsCredentials::class, 'credential');
    }
    public function contact(): BelongsTo
    {
        return $this->belongsTo(AccountsContacts::class, 'contact');
    }
}
