<?php

namespace App\Repositories\Accounts\Components;

use App\Models\Accounts\Components\AccountsCredentials;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface AccountsCredentialsRepositoryInterface
{
    public function Create(...$args): AccountsCredentials;
    public function Find(string $id) : null|AccountsCredentials|Collection|Model;
}
