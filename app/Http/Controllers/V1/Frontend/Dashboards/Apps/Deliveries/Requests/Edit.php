<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Requests;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Edit extends Controller
{
    public function index($id)
    {
        return view('dashboards.apps.deliveries.requests.edit', [
            'requestId' => $id
        ]);
    }
}
