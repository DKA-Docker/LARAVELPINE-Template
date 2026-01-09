<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Settings\Vehicles;

use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class Index extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request): View
    {
        return view('dashboards.settings.vehicles.index');
    }
}
