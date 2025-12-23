<?php

namespace App\Models\Base\Chats;

use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'receiver_id', 'body'];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(Accounts::class, 'user_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Accounts::class, 'receiver_id');
    }
}
