<?php

namespace App\Repositories\Accounts\Components;

use App\Models\Accounts\Components\AccountsCredentials;
use App\Models\Accounts\Components\AccountsInformations;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface AccountsInformationsRepositoryInterface
{
    public function Create(...$args): AccountsInformations;
}
