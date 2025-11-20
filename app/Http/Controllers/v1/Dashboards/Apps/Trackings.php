<?php

namespace App\Http\Controllers\v1\Dashboards\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class Trackings extends Controller
{
    public function index(): Factory|View
    {
        return view('dashboards.apps.trackings');
    }
}
