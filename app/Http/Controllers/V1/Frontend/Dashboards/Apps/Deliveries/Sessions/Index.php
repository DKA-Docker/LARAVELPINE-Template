<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Sessions;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class Index extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(): Factory|View
    {
        return view('dashboards.apps.deliveries.sessions.index');
    }
}
