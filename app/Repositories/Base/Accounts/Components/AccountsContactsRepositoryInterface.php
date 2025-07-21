<?php

namespace App\Repositories\Base\Accounts\Components;

use App\Models\Base\Accounts\Components\AccountsContacts;

interface AccountsContactsRepositoryInterface
{
    public function Create(...$args): AccountsContacts;
}
