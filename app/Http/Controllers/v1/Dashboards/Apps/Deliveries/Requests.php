<?php

namespace App\Http\Controllers\v1\Dashboards\Apps\Deliveries;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class Requests extends Controller
{
    public function index(): Factory|View
    {
        return view('dashboards.apps.deliveries.requests');
    }
}
