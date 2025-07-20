<?php

namespace App\Http\Controllers\Dashboard\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
class Logout
{

    public function index(): RedirectResponse
    {
        /** Get All Request Data */
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }

}
