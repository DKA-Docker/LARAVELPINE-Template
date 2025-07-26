<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Requests\AuthAccountsRequest;
use App\Services\Auth\AuthAccountsServices;
use Illuminate\Support\Facades\Auth;

class Login
{
    private string $theme;
    protected AuthAccountsServices $account;

    public function __construct(null|string $theme)
    {
        $this->theme = $theme ?? env("VITE_THEME_NAME","maxton");
        $this->account = new AuthAccountsServices();
    }

    public function index(){
        if (Auth::check()) return redirect()->route('dashboards.index');
        return view("dashboard.".$this->theme.".pages.auth.login", [
            'theme' => $this->theme
        ]);
    }

    public function store(AuthAccountsRequest $request)
    {
        /** Get All Request Data */
        $validated = $request->validated(); // hanya data tervalidasi
        $authenticate = $this->account->authenticate($validated);
        if ($authenticate['status']) return redirect()->route('dashboards.index');
        return back()->withErrors([
            'email' => 'Login gagal. Cek email atau password.',
        ])->onlyInput('email');
    }

}
