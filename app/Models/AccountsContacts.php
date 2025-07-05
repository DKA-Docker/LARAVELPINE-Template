<?php

namespace App\Models;

use Database\Factories\AccountsContactsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountsContacts extends Model
{
    /** @use HasFactory<AccountsContactsFactory> */
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'email',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];
}
