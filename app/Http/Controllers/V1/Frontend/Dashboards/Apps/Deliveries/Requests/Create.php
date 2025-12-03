<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Requests;


use App\Services\Resources\Deliveries\Requests\ResourcesDeliveriesRequestsServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class Create extends Controller
{
    protected ResourcesDeliveriesRequestsServices $services;
    public function __construct()
    {
        $this->services = new ResourcesDeliveriesRequestsServices();
    }

    public function index(): Factory|View
    {

        return view('dashboards.apps.deliveries.requests.create');
    }


    public function store(Request $request)
    {

    }


}
