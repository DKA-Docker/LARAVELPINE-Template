<?php

namespace App\Livewire\Metronic\Frontends\Auth\Components;

use App\Services\Auth\AuthAccountsServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Logout extends Component
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

        $result = $this->authServices->revoke();

        if (!$result['status']){
            $this->addError('error', 'Gagal mengeluarkan sesi saat ini. silahka coba lagi');
            return false;
        }
        return redirect()->route('auth.index');
    }

    public function render(): Factory|View
    {
        return view('frontends.auth.components.logout');
    }
}
