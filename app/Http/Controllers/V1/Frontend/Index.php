<?php

namespace App\Http\Controllers\V1\Frontend;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Index extends Controller
{
    //
    public function index(): RedirectResponse
    {
        return redirect()->route('auth.index');
    }
}
