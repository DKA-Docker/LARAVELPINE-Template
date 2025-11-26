<?php

namespace App\Http\Controllers\V1\Frontend\Auth;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class Index extends Controller
{
    //
    public function index(): Factory|View
    {
        return view('frontends.auth.index');
    }


}
