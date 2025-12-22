<?php

namespace App\Livewire\Metronic\Frontends\Auth\Components;

use App\Services\Auth\AuthAccountsServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Login extends Component
{


    public string $username = '';
    public string $password = '';
    /** @var bool $remember login Auth Credential */
    public bool $remember = false;
    /** @var AuthAccountsServices
     * Buat Instance protector untuk Auth Services
     */
    protected AuthAccountsServices $authServices;

    public function __construct(){
        /**
         * Memuat service yang di butuhkan di dalam aplikasi service agar dilakukan authentification yang sesuai di dalam aplikasi
         */
        $this->authServices = new AuthAccountsServices();
    }

    /**
     * Disini adalah method yang di parsing dari live:wire agar memicu metode ini di dalam component
     */
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
            'guard' => 'web', // 🟢 PASTIKAN INI DITAMBAHKAN UNTUK MENDAPATKAN TOKEN
        ));

        if (!$result['status']){
            $this->addError('errors', $result['msg']);
            /** Hentikan logic agar command di bawah tidak berjalan */
            return false;
        }
        /** Lakukan Redirect ke halaman dashboards jika result.status bernilai true */
        return redirect()->route('dashboards.index');
    }

    /**
     * @return Factory|View
     * Function Ini yang digunakan dalam mwerender document di dalam data aplikasi agar diteruskan di livewire di dalam blade component     */
    public function render(): Factory|View
    {
        return view('frontends.auth.components.login');
    }
}
