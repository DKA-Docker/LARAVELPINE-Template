<?php

namespace App\Http\Controllers\Dashboards\Apps\Deliveries;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class Reports extends Controller
{
    public function index(): Factory|View
    {
        return view('dashboards.apps.deliveries.reports');
    }
}
