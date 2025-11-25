<?php

namespace App\Repositories\Base\Accounts\Components\Informations;

use App\Models\Base\Accounts\Components\AccountsInformations;

interface AccountsInformationsRepositoryInterface
{
    public function Create(...$args): AccountsInformations;
}
