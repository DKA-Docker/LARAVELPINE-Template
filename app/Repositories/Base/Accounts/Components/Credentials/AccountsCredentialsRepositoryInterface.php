<?php

namespace App\Repositories\Base\Accounts\Components\Credentials;

use App\Models\Base\Accounts\Components\AccountsCredentials;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface AccountsCredentialsRepositoryInterface
{
    public function Create(...$args): AccountsCredentials;
    public function Find(string $id) : null|AccountsCredentials|Collection|Model;
}
