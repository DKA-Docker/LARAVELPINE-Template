<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;

class Create extends Controller {
    public function index(){
        return view('dashboards.apps.deliveries.tasks.create');
    }
}

