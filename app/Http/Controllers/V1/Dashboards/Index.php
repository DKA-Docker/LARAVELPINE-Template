<?php

namespace App\Http\Controllers\V1\Dashboards;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class Index extends Controller
{
    //
    public function index(): Factory|View
    {
        return view('dashboards.index');
    }
}
