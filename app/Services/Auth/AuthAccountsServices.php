<?php

namespace App\Services\Auth;

use App\Models\Base\Accounts\Accounts;
use App\Repositories\Base\Accounts\AccountsRepository;
use App\Repositories\Base\Accounts\Components\Contacts\AccountsContactsRepository;
use App\Repositories\Base\Accounts\Components\Credentials\AccountsCredentialsRepository;
use App\Repositories\Base\Accounts\Components\Informations\AccountsInformationsRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthAccountsServices {

    /**
     * init dulu local variablenya
     */
    protected AccountsRepository $account;
    protected AccountsInformationsRepository $information;
    protected AccountsCredentialsRepository $credential;
    protected AccountsContactsRepository $contact;

    public function __construct()
    {
        /**
         * init dahulu repositorynya sebelum dipakai methodnya
         */
        $this->account = new AccountsRepository();
        $this->information = new AccountsInformationsRepository();
        $this->credential = new AccountsCredentialsRepository();
        $this->contact = new AccountsContactsRepository();
    }

    /**
     * @param array{
     *     username: string,
     *     password: string,
     * } $args
     * @return array{
     *     status: bool,
     *     code: int,
     *     msg: string,
     * }
     */
    public function authenticate(array $args): array
    {
        $defaults = [
            'username' => '',
            'password' => '',
        ];

        $data = array_merge($defaults, $args);

        /** @var Accounts|null $account
         * @desc Lakukan merge relation dengan table members
         */
        $account = Accounts::with(['information', 'contact', 'credential'])
            ->whereHas('credential', fn($q) => $q->where('username', $data['username']))
            ->first();
        /** Validasi akun dan password */
        if (!$account || !Hash::check($data['password'], $account->password)) {
            return [
                'status' => false,
                'code' => 401,
                'msg' => 'Invalid credentials',
            ];
        }

        Auth::guard('web')->login($account);
        request()->session()->regenerate();

        return [
            'status' => true,
            'code' => 200,
            'msg' => 'Successfully logged in (web)',
        ];
    }

    public function verifyPassword(array $args): array
    {
        $defaults = [
            'id' => null,
            'password' => null,
        ];

        $data = array_merge($defaults, $args);

        /** @var Accounts|null $account */
        $account = Accounts::with(['information', 'contact', 'credential'])
            ->where('id',$data['id'])
            ->first();
        // Validasi akun dan password
        if (!$account || !Hash::check($data['password'], $account->password)) {
            return [
                'status' => false,
                'code' => 401,
                'msg' => 'Password Not Match',
            ];
        }

        return [
            'status' => true,
            'code' => 200,
            'msg' => 'Successfully logged in (web)',
        ];
    }

    /**
     * @param Authenticatable|null $authenticate
     * @return mixed
     * @desc authorize adalah aksi yang terjadi setelah login berhasil
     */
    public function authorize(Authenticatable|null $authenticate): array
    {
        /** @var $account mixed cari id usernya dari session */
        $account = $this->account->Find($authenticate->getAuthIdentifier());
        /** Load semua relasi akun */
        $data = $account->load(['information', 'credential', 'contact']);
        /** Kembalikan Callback data Bahwa authorization telah berhasil ke pengguna */
        return [
            "status" => true,
            "code" => 200,
            "msg" => "Successfully get data",
            "data" => $data, // ubah akun dan relasi ke array
        ];
    }

    public function verify(): array
    {
        /** @var $auth Authenticatable ambil data verification dari data user yang login saat ini. */
        $auth = Auth::guard('web')->user();
        /** Check If Auth Exists */
        if ($auth) {
            /** @var  $account Model adalah data load relation  */
            $account = $auth->load(['information', 'credential', 'contact']);
            /** Kembalikan Callback Array Response Ke function Ini */
            return [
                "status" => true,
                "code" => 200,
                "msg" => "Successfully get data",
                "data" => $account->toArray(), // biar frontend gampang parsing
            ];
        }

        /** Jika Tidak ada maka kembalikan Unauthorized */
        return [
            "status" => false,
            "code" => 401,
            "msg" => "Unauthorized",
        ];
    }

    public function revoke(): array
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable|null $authenticate */
        $authenticate = Auth::guard('web')->user();

        // Kalau nggak ada yang login, balikin info aja
        if (!$authenticate) {
            return [
                "status" => false,
                "code"   => 401,
                "msg"    => "Session Not Exists",
            ];
        }

        /** @var \App\Models\Base\Accounts\Accounts $account */
        $account = $this->account->Find($authenticate->getAuthIdentifier());
        $data    = $account->load(['information', 'credential', 'contact']);

        // Opsional: kalau suatu saat kamu pakai Sanctum juga, tetap aman:
        if (method_exists($authenticate, 'currentAccessToken')) {
            $token = $authenticate->currentAccessToken();
            if ($token) {
                $token->delete(); // nggak bakal error walau tanpa token
            }
        }

        // Logout session web
        Auth::guard('web')->logout();

        // Invalidate & regenerate CSRF biar clean
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return [
            "status" => true,
            "code"   => 200,
            "msg"    => "Successfully revoke session",
            "data"   => $data,
        ];
    }

}
