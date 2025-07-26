<?php

namespace App\Services\Resources;

use App\Repositories\Base\Accounts\AccountsRepository;
use App\Repositories\Base\Accounts\Components\AccountsContactsRepository;
use App\Repositories\Base\Accounts\Components\AccountsCredentialsRepository;
use App\Repositories\Base\Accounts\Components\AccountsInformationsRepository;
use App\Services\Auth\AuthAccountsServices;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class ResourcesAccountsServices {

    /**
     * init dulu local variablenya
     */
    protected AccountsRepository $account;
    protected AccountsInformationsRepository $information;
    protected AccountsCredentialsRepository $credential;
    protected AccountsContactsRepository $contact;

    protected AuthAccountsServices $accountServices;

    public function __construct()
    {
        /**
         * init dahulu repositorynya sebelum dipakai methodnya
         */
        $this->account = new AccountsRepository();
        $this->information = new AccountsInformationsRepository();
        $this->credential = new AccountsCredentialsRepository();
        $this->contact = new AccountsContactsRepository();

        $this->accountServices = new AuthAccountsServices();
    }

    /**
     * @return mixed
     */
    public function Create($payload): array
    {
        try {
            /** Start Transaction Procedure  */
            return DB::transaction(function () use ($payload) {
                /** Create Information Data */
                $information = $this->information->Create(...$payload['information'] ?? []);
                /** Create Credential Data */
                $credential = $this->credential->Create(...$payload['credential'] ?? []);
                /** Create Contact Data */
                $contact = $this->contact->Create(...$payload['contact'] ?? []);

                $account = $this->account->Create(
                    information: $information->id,
                    credential: $credential->id,
                    contact: $contact->id,
                );

                /** Buat Data Account Yang di Create Menampilkan data Lengkap dari foreignnya */
                $account->load(['information', 'credential', 'contact']);

                /** Successfully create Account */
                return [
                    'status' => true,
                    'code' => 201,
                    'msg' => 'Account Successfully Created',
                    'data' => $account,
                ];
            });
        } catch (QueryException $e) {
            /**  $sqlCode ambil error sqlnya  */
            $sqlCode = $e->errorInfo[1] ?? 0;

            // Mapping SQL Error Code ke HTTP Status Code
            $httpCode = match ($sqlCode) {
                1062 => 409,    // Duplicate entry
                1048, 1452 => 422,    // Column cannot be null
                // Foreign key constraint fails
                default => 500, // Generic DB error
            };

            // Ubah Ke Dalam format Standar API
            return [
                'status' => false,
                'code' => $httpCode,
                'msg' => 'Failed To Processing Data',
                'details' => [
                    "code" => $sqlCode,
                    "msg" =>  $e->getMessage()
                ]
            ];
        } catch (Throwable $e) {
            /** AKsi Untuk Error Yang Tidak Dikenali  */
            return [
                'status' => false,
                'code' => 500,
                'msg' => 'Unexpected error: ' . $e->getMessage()
            ];
        }
    }

    public function Update(array $payload): array
    {
        try {
            return DB::transaction(function () use ($payload) {
                // Ambil data akun
                $account = $this->account->Find($payload['id']);

                // Update relasi information jika ada
                if (!empty($payload['information'])) {
                    $this->information->Update($account->information, $payload['information']);
                }

                // Update relasi credential jika ada
                if (!empty($payload['credential'])) {
                    $credential = $payload['credential'];
                    $updatedCredential = $credential;

                    if (!empty($credential['new_password'])) {
                        // Validasi old_password wajib jika ingin ganti password
                        if (empty($credential['old_password'])) {
                            throw ValidationException::withMessages([
                                'credential.old_password' => 'Password saat ini dibutuhkan untuk mengganti password.'
                            ]);
                        }

                        // Verifikasi old_password
                        $verify = $this->accountServices->verifyPassword([
                            'id' => $payload['id'],
                            'password' => $credential['old_password'],
                        ]);

                        if (!$verify['status']) {
                            throw ValidationException::withMessages([
                                'credential.old_password' => 'Password saat ini salah.'
                            ]);
                        }

                        // Siapkan field credential baru
                        $updatedCredential['password'] = $credential['new_password'];
                        unset($updatedCredential['old_password'], $updatedCredential['new_password']);
                    }

                    // Update credential
                    $this->credential->Update($account->credential, $updatedCredential);
                }

                // Update relasi contact jika ada
                if (!empty($payload['contact'])) {
                    $this->contact->Update($account->contact, $payload['contact']);
                }

                // Reload data account setelah update
                $account->load(['information', 'credential', 'contact']);

                return [
                    'status' => true,
                    'code' => 200,
                    'msg' => 'Account Successfully Updated',
                    'data' => $account,
                ];
            });
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'code' => 422,
                'msg' => 'Validasi gagal.',
                'errors' => $e->errors()
            ];
        } catch (QueryException $e) {
            $sqlCode = $e->errorInfo[1] ?? 0;
            $httpCode = match ($sqlCode) {
                1062 => 409,       // Duplicate
                1048, 1452 => 422, // Not null / Foreign key constraint
                default => 500,
            };

            return [
                'status' => false,
                'code' => $httpCode,
                'msg' => 'Failed To Update Data',
                'details' => [
                    "code" => $sqlCode,
                    "msg" => $e->getMessage()
                ]
            ];
        } catch (Throwable $e) {
            return [
                'status' => false,
                'code' => 500,
                'msg' => 'Unexpected error: ' . $e->getMessage()
            ];
        }
    }



    public function GetAccountWithUsername(string $username)
    {
        return $this->account
            ->with(['credential', 'contact', 'information'])
            ->whereHas('credential', fn($q) => $q->where('username', $username))
            ->first();
    }
    /**
     * @return mixed
     */
    public function ReadAll(): array
    {
        try {
            // Read All Accounts
            $account = $this->account->ReadAll();
            /** Check Account Not Exists */
            if ($account->count() > 0){
                /** Buat Data Account Yang di Create Menampilkan data Lengkap dari foreignnya */
                $account->load(['information', 'credential', 'contact']);
                /** Successfully create Account */
                return [
                    'status' => true,
                    'code' => 200,
                    'msg' => 'Accounts Successfully Reads',
                    'data' => $account,
                ];
            }else{
                /** Successfully create Account */
                return [
                    'status' => true,
                    'code' => 404,
                    'msg' => 'Accounts Is Not Exist or Empty',
                    'data' => $account,
                ];
            }
        } catch (QueryException $e) {
            /**  $sqlCode ambil error sqlnya  */
            $sqlCode = $e->errorInfo[1] ?? 0;

            // Mapping SQL Error Code ke HTTP Status Code
            $httpCode = match ($sqlCode) {
                1062 => 409,    // Duplicate entry
                1048, 1452 => 422,    // Column cannot be null
                // Foreign key constraint fails
                default => 500, // Generic DB error
            };

            // Ubah Ke Dalam format Standar API
            return [
                'status' => false,
                'code' => $httpCode,
                'msg' => 'Failed To Processing Data',
                'details' => [
                    "code" => $sqlCode,
                    "msg" =>  $e->getMessage()
                ]
            ];
        } catch (Throwable $e) {
            /** AKsi Untuk Error Yang Tidak Dikenali  */
            return [
                'status' => false,
                'code' => 500,
                'msg' => 'Unexpected error: ' . $e->getMessage()
            ];
        }
    }

}
