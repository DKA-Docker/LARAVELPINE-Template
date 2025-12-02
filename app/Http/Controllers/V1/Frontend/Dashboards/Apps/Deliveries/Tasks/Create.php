<?php

namespace App\Http\Controllers\V1\Frontend\Dashboards\Apps\Deliveries\Tasks;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class Create extends Controller
{


    public function index()
    {
        $pass = array(
            'url_create' => Route::currentRouteName(),
        );

        return view('dashboards.apps.deliveries.tasks.create', $pass);
    }

    /**
     * @throws ConnectionException
     */
    public function store(Request $request)
    {
        $data = $request->all();
//        return $data;

        $endPoint  = route("api.".Route::currentRouteName());
        Debugbar::log($endPoint);
        $response = Http::acceptJson()
            ->asForm() // karena di curl pakai -d form-urlencoded
            ->post($endPoint, $data);
        Debugbar::log($response);

        $body = $response->json(); // atau ->body()
        Debugbar::log($body);

        if ($body["status"]) {
            return redirect()->route("api".Route::currentRouteName().".index");
        }
        return redirect()->back()->withErrors(["error" => $body["message"]]);
    }
}

