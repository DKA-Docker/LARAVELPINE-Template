<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks;

use App\Services\Resources\Deliveries\Tasks\ResourcesDeliveriesTasksServices;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;

class Edit extends Controller
{
    public function index($id)
    {
        // Pass task ID to the view
        return view('dashboards.apps.deliveries.tasks.edit', ['taskId' => $id]);
    }
}
