<?php

namespace App\Models\Base\Accounts\Components;

use Database\Factories\Base\Accounts\Components\AccountsContactsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountsContacts extends Model
{
    /** @use HasFactory<AccountsContactsFactory> */
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'email',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
