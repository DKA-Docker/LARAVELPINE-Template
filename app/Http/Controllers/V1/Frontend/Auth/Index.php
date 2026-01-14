<?php

namespace App\Http\Controllers\V1\Frontend\Auth;

use App\Services\Auth\AuthAccountsServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class Index extends Controller
{
    protected AuthAccountsServices $auth;
    public function __construct()
    {
        $this->auth = new AuthAccountsServices();
    }

    //
    public function index(): RedirectResponse|Factory|View
    {
        /** @var object $AuthVerification
         * ambil method verifikasi di services auth
         */
        $AuthVerification = $this->auth->verify();
        /**
         *
         * if response status === false.
         * show the login.
         */
        if (!$AuthVerification['status']) {
            return view('frontends.auth.index');
        }
        /** if status verification true. redirect to home */
        return redirect()->route('dashboards.index');
    }

    public function register()
    {
        // Cek jika user sudah login, redirect ke dashboard (opsional)
        // $AuthVerification = $this->auth->verify();
        // if ($AuthVerification['status']) {
        //    return redirect()->route('dashboards.index');
        // }

        return view('frontends.auth.register');
    }

    public function forgotPassword()
    {
        return view('frontends.auth.forgot-password');
    }


}
