<?php

namespace App\Models\Base\Accounts\Components;

use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class AccountsCredentials extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'username',
        'password',
    ];

    protected $hidden = [
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
        // Kalau nilainya null atau kosong, abaikan
        if (empty($value)) return;
        // Ambil password lama dari model (kalau sudah ada di DB)
        $currentPassword = $this->getOriginal('password');
        // Kalau value belum berubah, jangan set ulang
        if ($value === $currentPassword) return;
        // Kalau belum di-hash atau hash-nya butuh refresh, hash sekarang
        $this->attributes['password'] = Hash::needsRehash($value)
            ? Hash::make($value)
            : $value;
    }

    public function account(): HasOne
    {
        return $this->hasOne(Accounts::class, 'credential', 'id');
    }
}
