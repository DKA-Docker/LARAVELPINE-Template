<?php

namespace App\Http\Controllers\Dashboard;

class Dashboard
{
    private string $theme;

    public function __construct($theme = "maxton")
    {
        $this->theme = $theme;
    }

    public function index(){
        return view("dashboard.index", [ 'theme' => $this->theme ]);
    }
}
