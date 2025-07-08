<?php

namespace App\Repositories\Accounts;

use App\Models\Accounts\Accounts;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface AccountsRepositoryInterface
{
    public function Create(...$args): Model|Accounts;

    public function ReadAll(): Collection;

    public function Find($id) : null|Collection|Accounts|Model;
}
