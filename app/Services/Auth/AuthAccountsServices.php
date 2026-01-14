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
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

// Pastikan ini di-import jika menggunakan Sanctum

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
     * username: string,
     * password: string,
     * guard: 'web'|'api', // 🟢 Tambahkan parameter guard
     * } $args
     * @return array{
     * status: bool,
     * code: int,
     * msg: string,
     * token?: string, // 🟢 Tambahkan token opsional untuk API
     * }
     */
    public function authenticate(array $args): array
    {
        $defaults = [
            'username' => '',
            'password' => '',
            'guard' => 'web', // Default ke 'web'
        ];

        $data = array_merge($defaults, $args);

        /** @var Accounts|null $account
         * @desc Lakukan merge relation dengan table members
         */
        $account = Accounts::with(['information', 'contact', 'credential', 'firebase'])
            ->whereHas('credential', fn($q) => $q->where('username', $data['username']))
            ->first();

        /** Validasi akun dan password */
        if (!$account || !Hash::check($data['password'], $account->password)) {
            return [
                'status' => false,
                'code' => Response::HTTP_UNAUTHORIZED,
                'msg' => 'Invalid credentials',
            ];
        }

        // 🟢 LOGIKA AUTENTIKASI FLEKSIBEL
        if ($data['guard'] === 'api') {

            // 1. Logika API Guard (Sanctum/Token)

            // Opsional: Hapus token lama sebelum membuat yang baru.
            // $account->tokens()->delete();

            // Buat token baru
            $token = $account->createToken('auth-token', ['read', 'write']);

            return [
                'status' => true,
                'code' => Response::HTTP_OK,
                'msg' => 'Successfully logged in (api)',
                'data' => $token->plainTextToken, // Kembalikan token mentah
            ];

        } else {

            // 2. Logika Web Guard (Session)

            Auth::guard('web')->login($account);
            request()->session()->regenerate();

            return [
                'status' => true,
                'code' => 200,
                'msg' => 'Successfully logged in (web)',
            ];
        }
    }

    // ... (Metode lainnya seperti verifyPassword, authorize, verify, dan revoke tetap sama)

    // Metode verifyPassword tidak perlu diubah.

    // Metode authorize tidak perlu diubah.




    public function verify(): array

    {
        /** @var $auth Authenticatable ambil data verification dari data user yang login saat ini. */
        $auth = Auth::guard('web')->user() ?? Auth::guard('sanctum')->user();
        /** Check If Auth Exists */
        if ($auth) {
            /** @var  $account Model adalah data load relation  */
            $account = $auth->load(['information', 'credential', 'contact']);
            /** Kembalikan Callback Array Response Ke function Ini */
            return [
                "status" => true,
                "code" => Response::HTTP_OK,
                "msg" => "Successfully verified",
                "data" => $account->toArray(), // biar frontend gampang parsing
            ];
        }

        /** Jika Tidak ada maka kembalikan Unauthorized */
        return [
            "status" => false,
            "code" => Response::HTTP_UNAUTHORIZED,
            "msg" => "Unauthorized",
        ];
    }

    public function revoke(): array
    {
        /** @var Authenticatable|null $authenticate */
        $authenticate = Auth::guard('web')->user() ?? Auth::guard('sanctum')->user();

        // Kalau nggak ada yang login, balikin info aja
        if (!$authenticate) {
            return [
                "status" => false,
                "code"   => 401,
                "msg"    => "Session Not Exists",
            ];
        }

        /** @var Accounts $account */
        $account = $this->account->Find($authenticate->getAuthIdentifier());
        $data    = $account->load(['information', 'credential', 'contact']);

        // LOGIKA LOGOUT FLEKSIBEL
        if (Auth::guard('web')->check()) {
            // Logout Session Web
            Auth::guard('web')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();

        } elseif (Auth::guard('sanctum')->check()) {
            // Cabut Token API Sanctum
            $authenticate->currentAccessToken()->delete();
        }

        return [
            "status" => true,
            "code"   => 200,
            "msg"    => "Successfully revoked session/token",
            "data"   => $data->toArray(),
        ];
    }
}
