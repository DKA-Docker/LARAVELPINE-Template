<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Requests;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class Create extends Controller
{
    public function index(): Factory|View
    {
        return view('dashboards.apps.deliveries.requests.create');
    }


}
