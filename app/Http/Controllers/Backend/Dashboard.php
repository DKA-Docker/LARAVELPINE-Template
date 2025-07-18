<?php

namespace App\Http\Controllers\Backend;

class Dashboard
{
    private string $theme;

    public function __construct($theme = "maxton")
    {
        $this->theme = $theme;
    }

    public function index(){
        return view("backend.index", [ 'theme' => $this->theme ]);
    }
}
