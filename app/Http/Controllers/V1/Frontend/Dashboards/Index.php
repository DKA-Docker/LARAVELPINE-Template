<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Index extends Controller
{
    //
    public function index(): Factory|View
    {
        return view('dashboards.index');
    }
}
