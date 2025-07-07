<?php

namespace App\Models\Accounts;

use App\Models\Accounts\Components\AccountsContacts;
use App\Models\Accounts\Components\AccountsCredentials;
use App\Models\Accounts\Components\AccountsInformations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

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
