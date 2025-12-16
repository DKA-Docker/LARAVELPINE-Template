<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Show extends Controller
{
    public function show(): Factory|View
    {
        return view('dashboards.apps.deliveries.tasks.show');
    }
}
