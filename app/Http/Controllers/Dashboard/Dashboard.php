<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\Auth;

class Dashboard
{
    private string $theme;

    public function __construct($theme = "maxton")
    {
        $this->theme = $theme;
    }

    public function index(){
        $AuthAccount = Auth::user();
        $account = json_decode(json_encode($AuthAccount->toArray()));
        return view("dashboard.".$this->theme.".pages.dashboard.dashboard", [
            'theme' => $this->theme,
            'account' => $account
        ]);
    }
}
