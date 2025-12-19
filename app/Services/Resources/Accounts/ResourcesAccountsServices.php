<?php

namespace App\Services\Resources\Accounts;

use App\Helpers\Exceptions\HelpersExceptionsHttpCode;
use App\Models\Base\Accounts\Accounts;
use App\Repositories\Base\Accounts\AccountsRepository;
use App\Repositories\Base\Accounts\Components\Contacts\AccountsContactsRepository;
use App\Repositories\Base\Accounts\Components\Credentials\AccountsCredentialsRepository;
use App\Repositories\Base\Accounts\Components\Firebases\AccountsFirebasesRepository;
use App\Repositories\Base\Accounts\Components\Informations\AccountsInformationsRepository;
use App\Services\Auth\AuthAccountsServices;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Throwable;

class ResourcesAccountsServices
{
    /**
     * init dulu local variablenya
     */
    protected AccountsRepository $account;
    protected AccountsInformationsRepository $information;
    protected AccountsCredentialsRepository $credential;
    protected AccountsContactsRepository $contact;
    protected AccountsFirebasesRepository $firebase;
    protected AuthAccountsServices $authAccountServices;
    protected HelpersExceptionsHttpCode $HelpersExceptionsHttpCode;

    public function __construct()
    {
        /** init first the repository sebelum dipakai methodnya */
        $this->account        = new AccountsRepository();
        $this->information    = new AccountsInformationsRepository();
        $this->credential     = new AccountsCredentialsRepository();
        $this->contact        = new AccountsContactsRepository();
        $this->firebase       = new AccountsFirebasesRepository();
        $this->authAccountServices = new AuthAccountsServices();
        $this->HelpersExceptionsHttpCode = new HelpersExceptionsHttpCode();
    }

    /**
     * Creates Account (atomik) + afterCommit
     * @return array{status:bool,code:int,msg:string,data?:mixed,error?:mixed,details?:mixed}
     * @throws Throwable
     */
    public function Create(array $payload): array
    {
        /** Begin Transaction */
        DB::beginTransaction();
        try {
            // (opsional) validasi cepat; hapus jika repositori sudah handle
            Validator::make($payload, [
                'information' => ['required', 'array'],
                'credential'  => ['required', 'array'],
                'contact'     => ['required', 'array'],
                'firebase'    => ['required', 'array'],
                'roles'       => ['nullable', 'array'],
                'roles.*'     => ['string'],
            ])->validate();
            /**
             * @var $information array about information account
             * @var $credential  array about credential account
             * @var $contact     array about contact account
             * @var $firebase    array about Firebase account
             */
            $information = $this->information->Create(...($payload['information'] ?? []));
            $credential  = $this->credential->Create(...($payload['credential'] ?? []));
            $contact     = $this->contact->Create(...($payload['contact'] ?? []));
            $firebase     = $this->firebase->Create(...($payload['firebase'] ?? []));
            /** @var $account Accounts function account */
            $account = $this->account->Create(
                information: $information->id,
                credential : $credential->id,
                contact    : $contact->id,
                firebase   : $firebase->id,
            );
            /** role assignment: DI DALAM transaksi → atomik */
            if (!empty($payload['roles'])) {
                $this->account->Find($account->id)?->assignRole($payload['roles']);
            }
            /** Muat Relations Data */
            $account->load(['information', 'credential', 'contact', 'firebase']);
            /** daftar efek samping yang harus nunggu commit */
            DB::afterCommit(function () use ($account) {
                // Contoh: event(new \App\Events\AccountCreated($account->id));
                // Contoh: Cache::put("account:{$account->id}", $account->toArray(), now()->addHour());
            });
            /** Commit Data */
            DB::commit();
            /** Back Callback */
            return [
                'status' => true,
                'code'   => 201,
                'msg'    => 'Account Successfully Created',
                'data'   => $account,
            ];
        } catch (QueryException $e) {
            /** Cancel Changes Database */
            DB::rollBack();
            /** Convert The Database Error To Http Error Payload  */
            return $this->HelpersExceptionsHttpCode->fromSQLError($e);
        } catch (Throwable $e) {
            /** Cancel Changes Database */
            DB::rollBack();
            /** General Http Error Payload  */
            return [
                'status' => false,
                'code'   => 500,
                'msg'    => 'Unexpected error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Update Account (atomik) + afterCommit
     * @return array{status:bool,code:int,msg:string,data?:mixed,error?:mixed}
     */
    public function Update(array $payload): array
    {
        /** Begin Transaction */
        DB::beginTransaction();
        try {
            // (opsional) validasi id
            Validator::make($payload, [
                'id'          => ['required', 'string'],
                'information' => ['nullable', 'array'],
                'credential'  => ['nullable', 'array'],
                'contact'     => ['nullable', 'array'],
                'firebase'    => ['required', 'array'],
            ])->validate();
            /** Ambil data akun (wajib ada) */
            /** @var Accounts|null $account */
            $account = $this->account->Find($payload['id']);
            if (!$account) {
                DB::rollBack();
                return [
                    'status' => false,
                    'code'   => 404,
                    'msg'    => 'Account not found',
                ];
            }
            /** Update relasi information jika ada */
            if (!empty($payload['information'])) {
                $this->information->Update($account->information, $payload['information']);
            }
            /** Update relasi credential jika ada (support ganti password) */
            if (!empty($payload['credential'])) {
                $credential = $payload['credential'];
                $updatedCredential = $credential;
                if (!empty($credential['new_password'])) {
                    if (empty($credential['old_password'])) {
                        throw ValidationException::withMessages([
                            'credential.old_password' => 'Password saat ini dibutuhkan untuk mengganti password.',
                        ]);
                    }
                    $verify = $this->authAccountServices->verifyPassword([
                        'id'       => $payload['id'],
                        'password' => $credential['old_password'],
                    ]);
                    if (!$verify['status']) {
                        throw ValidationException::withMessages([
                            'credential.old_password' => 'Password saat ini salah.',
                        ]);
                    }
                    $updatedCredential['password'] = $credential['new_password'];
                    unset($updatedCredential['old_password'], $updatedCredential['new_password']);
                }

                $this->credential->Update($account->credential, $updatedCredential);
            }
            /** Update relasi contact jika ada */
            if (!empty($payload['contact'])) {
                $this->contact->Update($account->contact, $payload['contact']);
            }
            if (!empty($payload['firebase'])) {
                $this->firebase->Update($account->firebase, $payload['firebase']);
            }
            /** Reload relasi untuk response */
            $account->load(['information', 'credential', 'contact', 'firebase']);
            /** Side-effect yang harus nunggu commit */
            DB::afterCommit(function () use ($account) {
                // Contoh: event(new \App\Events\AccountUpdated($account->id));
                // Contoh: Cache::forget("account:{$account->id}");
            });

            DB::commit();
            return [
                'status' => true,
                'code'   => Response::HTTP_OK,
                'msg'    => 'Account Successfully Updated',
                'data'   => $account,
            ];
        } catch (QueryException $e) {
            DB::rollBack();
            return $this->HelpersExceptionsHttpCode->fromSQLError($e);
        } catch (Throwable $e) {
            DB::rollBack();
            if ($e instanceof ValidationException) {
                return [
                    'status' => false,
                    'code'   => 422,
                    'msg'    => 'Validation error',
                    'error'  => $e->errors(),
                ];
            }
            return [
                'status' => false,
                'code'   => 500,
                'msg'    => 'Unexpected error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Read all accounts (tanpa transaksi)
     * @return array{status:bool,code:int,msg:string,data?:mixed,details?:mixed}
     */
    public function ReadAll(): array
    {
        try {
            $account = $this->account->ReadAll();
            if ($account->count() > 0) {
                return [
                    'status' => true,
                    'code'   => 200,
                    'msg'    => 'Accounts Successfully Reads',
                    'data'   => $account->toArray(),
                ];
            }
            return [
                'status' => true,
                'code'   => 404,
                'msg'    => 'Accounts Is Not Exist or Empty',
                'data'   => $account,
            ];
        } catch (QueryException $e) {
            return $this->HelpersExceptionsHttpCode->fromSQLError($e);
        } catch (Throwable $e) {
            return [
                'status' => false,
                'code'   => 500,
                'msg'    => 'Unexpected error: ' . $e->getMessage(),
            ];
        }
    }


    /**
     * Mencari akun berdasarkan nama (First Name, Last Name, atau Username)
     * Menggunakan builder mentah dari repository.
     * @param string $name
     * @return array
     */
    public function FindByName(string $name): array
    {
        try {
            $term = '%' . $name . '%';

            // Menggunakan method query() dari AccountsRepository
            $query = $this->account->query()
                ->whereHas('information', function ($q) use ($term) {
                    $q->where('first_name', 'ilike', $term)
                        ->orWhere('last_name', 'ilike', $term);
                })
                ->orWhereHas('credential', function ($q) use ($term) {
                    $q->where('username', 'ilike', $term);
                });

            // Eksekusi dengan eager load dan limit
            $accounts = $query->with(['information', 'credential', 'contact', 'firebase'])
                ->limit(5)
                ->get();

            if ($accounts->isNotEmpty()) {
                return [
                    'status' => true,
                    'code'   => 200,
                    'msg'    => 'Accounts successfully found',
                    'data'   => $accounts->toArray(), // Penting: toArray agar Livewire lancar
                ];
            }

            return [
                'status' => true,
                'code'   => 404,
                'msg'    => 'No accounts found',
                'data'   => [],
            ];
        } catch (QueryException $e) {
            return $this->HelpersExceptionsHttpCode->fromSQLError($e);
        } catch (Throwable $e) {
            return [
                'status' => false,
                'code'   => 500,
                'msg'    => 'Unexpected error: ' . $e->getMessage(),
            ];
        }
    }
    /**
     * Delete (atomik) + afterCommit
     * @return array{status:bool,code:int,msg:string,data?:mixed}
     * @throws Throwable
     */
    public function Delete(string $id): array
    {
        DB::beginTransaction();
        try {
            /** @var Accounts|null $account */
            $account = $this->account->Find($id);
            if (!$account) {
                DB::rollBack();
                return [
                    'status' => false,
                    'code'   => 404,
                    'msg'    => 'Account not found',
                ];
            }

            // Hapus via repository; biarkan DB enforce FK
            $this->account->Delete($account);

            DB::afterCommit(function () use ($id) {
                // Contoh: revoke tokens, purge cache, audit trail
                // event(new \App\Events\AccountDeleted($id));
            });
            /** apply the changes */
            DB::commit();

            return [
                'status' => true,
                'code'   => 200,
                'msg'    => 'Account Successfully Deleted',
                'data'   => ['id' => $id],
            ];
        } catch (QueryException $e) {
            DB::rollBack();
            return $this->HelpersExceptionsHttpCode->fromSQLError($e);
        } catch (Throwable $e) {
            DB::rollBack();
            return [
                'status' => false,
                'code'   => 500,
                'msg'    => 'Unexpected error: ' . $e->getMessage(),
            ];
        }
    }
}
