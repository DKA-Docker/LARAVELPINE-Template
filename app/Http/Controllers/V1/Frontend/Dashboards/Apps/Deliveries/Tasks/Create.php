<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class Create extends Controller
{


    public function index()
    {
        $pass = array(
            'url_create' => 'api.' . implode('.', array_slice(explode('.', Route::currentRouteName()), 0, -2)).'.store',
        );
        return view('dashboards.apps.deliveries.tasks.create', $pass);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $response = Http::withToken('')
            ->acceptJson()
            ->asForm() // karena di curl pakai -d form-urlencoded
            ->post(route("api".Route::currentRouteName().".store"), $data);

        $body = $response->json(); // atau ->body()

        if ($body["status"]) {
            return redirect()->route("api".Route::currentRouteName().".index");
        }
        return redirect()->back()->withErrors(["error" => $body["message"]]);
    }
}

