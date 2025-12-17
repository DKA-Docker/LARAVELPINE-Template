<?php

namespace App\Repositories\Base\Accounts\Components\Firebases;

use App\Models\Base\Accounts\Components\AccountsFirebases;

interface AccountsFirebasesRepositoryInterface
{
    public function Create(...$args): AccountsFirebases;
}
