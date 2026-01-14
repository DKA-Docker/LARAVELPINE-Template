<?php

namespace App\Repositories\Base\Accounts\Components\Contacts;

use App\Models\Base\Accounts\Components\AccountsContacts;

interface AccountsContactsRepositoryInterface
{
    public function Update(int|string $id, array $data): AccountsContacts;
    public function FindByEmail(string $email): ?AccountsContacts;
}
