<?php

namespace App\Services\Auth;

use App\Repositories\AccountsContactsRepository;
use App\Repositories\AccountsCredentialsRepository;
use App\Repositories\AccountsInformationsRepository;
use App\Repositories\AccountsRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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

    public function authenticate(array $args): array
    {
        /** @var $defaults
         * jika data inputan kosong maka ambil dari faker,
         */
        $defaults = [
            'username' => '',
            'password' => '',
        ];

        /**
         * Jika Ada data inputnya maka akan digunakan data inputnya
         */
        $data = array_merge($defaults, $args);

        if (!Auth::attempt($data)) {
            return [
                'status' => false,
                'code' => 403,
                'msg' => 'wrong credentials data. authenticate failed'
            ];
        }
        // Getting User Auth
        $user = Auth::user();
        // Ambil Nama Token dari Env
        $nameOfToken = env('APP_NAME', 'Laravel');
        // Ambil Session Life sama dengan Api
        $minutes = (int) env('SESSION_LIFETIME', 120); // pastikan bertipe integer
        // Tambahkan Waktu Sekarang Dengan Waku Session Hidup
        $expiresAt = now()->addMinutes($minutes);
        /** Funtion Pengembalian Data */
        return [
            'type' => 'Bearer',
            'access_token' => $user->createToken(
                name: $nameOfToken,
                expiresAt: $expiresAt
            )->plainTextToken
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
        return [
            "status" => true,
            "code" => 200,
            "msg" => "Successfully get data",
            "data" => $data, // ubah akun dan relasi ke array
        ];
    }
}
