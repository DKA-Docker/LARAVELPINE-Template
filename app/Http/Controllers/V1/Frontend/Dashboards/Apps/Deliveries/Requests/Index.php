<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Requests;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class Index extends Controller
{
    public function index(): Factory|View
    {
        return view('dashboards.apps.deliveries.requests.index');
    }

    public function show($id): Factory|View
    {
        return view('dashboards.apps.deliveries.requests.detail-page', ['requestId' => $id]);
    }
}
