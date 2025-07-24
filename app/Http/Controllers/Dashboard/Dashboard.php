<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Factory;
use Illuminate\View\View;

class Dashboard
{
    private string $theme;

    public function __construct(null|string $theme)
    {
        $this->theme = $theme ?? env("VITE_THEME_NAME","maxton");
    }

    public function index(): Factory|Application|View
    {
        $AuthAccount = Auth::user();
        /** @var {{ String }} $session */
        $session = json_decode(json_encode($AuthAccount->toArray()));
        return view("dashboard.".$this->theme.".pages.dashboard.dashboard", [
            'theme' => $this->theme,
            'session' => $session
        ]);
    }
}
