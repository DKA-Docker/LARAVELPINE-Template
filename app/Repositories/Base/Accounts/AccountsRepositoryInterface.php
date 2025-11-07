<?php

namespace App\Repositories\Base\Accounts;

use App\Models\Base\Accounts\Accounts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface AccountsRepositoryInterface
{
    public function Create(...$args): Model|Accounts;

    public function ReadAll(): Collection;

    public function Find($id) : null|Collection|Accounts|Model;

    public function query(): Builder;

    public function Delete($id) : bool|null;
}
