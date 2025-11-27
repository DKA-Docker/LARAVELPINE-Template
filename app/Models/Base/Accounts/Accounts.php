<?php

namespace App\Models\Base\Accounts;

use App\Models\Base\Accounts\Components\AccountsContacts;
use App\Models\Base\Accounts\Components\AccountsCredentials;
use App\Models\Base\Accounts\Components\AccountsInformations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class Accounts extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    /** Auto-load relasi credential, contact, dan information */
    protected $with = ['credential', 'contact', 'information'];

    protected $guard_name = 'web';

    /** Kolom yang bisa diisi */
    protected $fillable = [
//        'id',
        'information',
        'credential',
        'contact',
        'created_at',
        'updated_at',
    ];

    /** Kolom yang disembunyikan dari JSON output */
    protected $hidden = [
        'remember_token',
        'deleted_at',
        'password', // Hide accessor password biar gak bocor hash
    ];

    /** Cast tipe data */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ================= RELATIONSHIP =================

    /** Relasi ke AccountsCredentials (credential ID disimpan di kolom `credential`) */
    public function credential(): BelongsTo
    {
        return $this->belongsTo(AccountsCredentials::class, 'credential')->withDefault();
    }

    /** Relasi ke Contacts (contact ID disimpan di kolom `contact`) */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(AccountsContacts::class, 'contact')->withDefault();
    }

    public function role(): HasOne
    {
        return $this->hasOne(Role::class, 'id')->withDefault();
    }

    /** Relasi ke AccountsInformations (information ID disimpan di kolom `information`) */
    public function information(): BelongsTo
    {
        return $this->belongsTo(AccountsInformations::class, 'information')->withDefault();
    }

    // ================= ACCESSOR =================

    /** Ambil username dari relasi credential */
    public function getUsernameAttribute()
    {
        return $this->getRelationValue('credential')?->username;
    }

    /** Ambil password hash dari relasi credential */
    public function getPasswordAttribute()
    {
        return $this->getRelationValue('credential')?->password;
    }

    // ================= AUTH IMPLEMENTATION =================

    /** Override untuk memberitahu Laravel password-nya ambil dari relasi */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /** (Opsional) Jika ingin override kolom primary key authentikasi */
    public function getAuthIdentifier()
    {
        return $this->attributes['id']; // Force ambil dari kolom utama, bukan relasi
    }
}
