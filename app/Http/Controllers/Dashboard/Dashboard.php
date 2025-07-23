<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\Auth;

class Dashboard
{
    private string $theme;

    public function __construct(null|string $theme)
    {
        $this->theme = $theme ?? env("VITE_THEME_NAME","maxton");
    }

    public function index(){
        $AuthAccount = Auth::user();
        $session = json_decode(json_encode($AuthAccount->toArray()));
        return view("dashboard.".$this->theme.".pages.dashboard.dashboard", [
            'theme' => $this->theme,
            'session' => $session
        ]);
    }
}
