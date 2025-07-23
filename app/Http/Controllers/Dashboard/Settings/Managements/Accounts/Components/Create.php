<?php

namespace App\Http\Controllers\Dashboard\Settings\Managements\Accounts\Components;

use App\Repositories\Base\Accounts\AccountsRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Application;

class Create extends Controller {
    private string $theme;
    private AccountsRepository $accountsRepository;


    public function __construct(null|string $theme)
    {
        $this->theme = $theme ?? env("VITE_THEME_NAME","maxton");
        $this->accountsRepository = new AccountsRepository();

        $this->middleware(['permission:dashboards.settings.managements.accounts.create'])->only('index');
    }

    public function index(): Factory|View|Application
    {
        $AuthAccount = Auth::user();
        $session = json_decode(json_encode($AuthAccount->toArray()));
        return view("dashboard.".$this->theme.".pages.dashboard.settings.managements.accounts.components.create", [
            'theme' => $this->theme,
            'session' => $session,
            'account' => $this->accountsRepository
        ]);
    }


}
