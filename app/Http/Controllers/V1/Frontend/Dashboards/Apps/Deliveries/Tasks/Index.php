<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class Index extends Controller
{
    public function index(): Factory|View
    {
        return view('dashboards.apps.deliveries.tasks.index');
    }

    public function show($id)
    {
        return view('dashboards.apps.deliveries.tasks.show');
    }
}
