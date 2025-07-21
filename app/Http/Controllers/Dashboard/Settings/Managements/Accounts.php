<?php

namespace App\Http\Controllers\Dashboard\Settings\Managements;

use App\Repositories\Base\Accounts\AccountsRepository;
use App\Services\Auth\AuthAccountsServices;
use Illuminate\Support\Facades\Auth;

class Accounts
{
    private string $theme;
    private AccountsRepository $accountsRepository;


    public function __construct(null|string $theme)
    {
        $this->theme = $theme ?? env("VITE_THEME_NAME","maxton");
        $this->accountsRepository = new AccountsRepository();
    }

    public function index(){
        $AuthAccount = Auth::user();
        $session = json_decode(json_encode($AuthAccount->toArray()));
        return view("dashboard.".$this->theme.".pages.dashboard.settings.managements.accounts", [
            'theme' => $this->theme,
            'session' => $session,
            'account' => $this->accountsRepository
        ]);
    }
}
