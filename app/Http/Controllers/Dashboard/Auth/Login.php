<?php

namespace App\Http\Controllers\Dashboard\Auth;

class Login
{
    private string $theme;

    public function __construct($theme = "maxton")
    {
        $this->theme = $theme;
    }

    public function index(){
        return view("dashboard.".$this->theme.".pages.auth.login", [
            'theme' => $this->theme
        ]);
    }
}
