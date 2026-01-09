<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Settings\Vehicles\Categories;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;

class Create extends Controller
{
    public function index()
    {
        return view('dashboards.settings.vehicles.categories.create');
    }
}
