<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Rates;

use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class Create extends Controller
{
    public function create(): Factory|View
    {
        return view('dashboards.apps.deliveries.rates.create');
    }
}
