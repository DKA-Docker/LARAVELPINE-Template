<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Managements\Accounts;

use App\Services\Resources\Deliveries\Tasks\ResourcesDeliveriesTaksServices;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class Create extends Controller
{

    public function index()
    {
        return view('dashboards.managements.accounts.create');
    }

}

