<?php

namespace App\Repositories\Accounts\Components;

use App\Models\Accounts\Components\AccountsContacts;

interface AccountsContactsRepositoryInterface
{
    public function Create(...$args): AccountsContacts;
}
