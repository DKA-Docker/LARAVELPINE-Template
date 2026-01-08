<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Rates;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class Index extends Controller
{
    public function index(): Factory|View
    {
        return view('dashboards.apps.deliveries.rates.index');
    }

    public function create(): Factory|View
    {
        return view('dashboards.apps.deliveries.rates.create');
    }

    public function edit(string $id): Factory|View
    {
        return view('dashboards.apps.deliveries.rates.edit', compact('id'));
    }
}
