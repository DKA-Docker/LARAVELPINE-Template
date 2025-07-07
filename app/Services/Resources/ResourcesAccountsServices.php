<?php

namespace App\Services\Resources;

use App\Repositories\AccountsContactsRepository;
use App\Repositories\AccountsCredentialsRepository;
use App\Repositories\AccountsInformationsRepository;
use App\Repositories\AccountsRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Throwable;

class ResourcesAccountsServices {

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
