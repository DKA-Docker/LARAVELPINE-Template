<?php

namespace App\Livewire\Metronic\Frontends\Auth\Components;

use App\Services\Auth\AuthAccountsServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{

    public string $username = '';
    public string $password = '';
    public bool $remember = false;
    protected AuthAccountsServices $authServices;

    public function __construct(){
        $this->authServices = new AuthAccountsServices();
    }

    public function store()
    {
        // validasi dulu
        $this->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $result = $this->authServices->authenticate(array(
            'username' => $this->username,
            'password' => $this->password,
        ));

        if (!$result['status']){
            $this->addError('username', 'Nama pengguna atau kata sandi salah.');
            return false;
        }
        return redirect()->route('dashboards.index');
    }

    public function render(): Factory|View
    {
        return view('frontends.auth.components.login');
    }
}
