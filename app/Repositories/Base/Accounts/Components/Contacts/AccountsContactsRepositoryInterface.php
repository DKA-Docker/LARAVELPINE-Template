<?php

namespace App\Repositories\Base\Accounts\Components\Contacts;

use App\Models\Base\Accounts\Components\AccountsContacts;

interface AccountsContactsRepositoryInterface
{
    public function Create(...$args): AccountsContacts;
}
