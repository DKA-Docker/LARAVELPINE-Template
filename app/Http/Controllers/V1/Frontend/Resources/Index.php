<?php

namespace App\Http\Controllers\V1\Frontend\Resources;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Index extends Controller
{
    /**
     * Display the privacy policy page.
     *
     * @return View|Factory
     */
    public function index(): View|Factory
    {
        return view('frontends.resources.index');
    }
}
