<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Requests extends Controller
{
    public function index(): Factory|View
    {
        return view('dashboards.apps.deliveries.requests');
    }
}
