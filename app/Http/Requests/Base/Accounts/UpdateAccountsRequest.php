<?php

namespace App\Http\Requests\Base\Accounts;

use App\Services\Auth\AuthAccountsServices;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateAccountsRequest extends FormRequest
{
    protected AuthAccountsServices $account;

    public function __construct()
    {
        parent::__construct();
        $this->account = new AuthAccountsServices();
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'information.first_name'      => 'nullable|string',
            'information.last_name'       => 'nullable|string',
            'credential.username'         => 'nullable|string|min:3',
            'credential.old_password'     => 'nullable|string|min:3',
            'credential.new_password'     => 'nullable|string|min:8',
            'credential.password'         => 'sometimes|nullable|string|min:8',
            'contact.email'               => 'nullable|email',
        ];
    }

    /**
     * Modifikasi data sebelum validasi dimulai
     */
    protected function prepareForValidation(): void
    {
        $credential = $this->input('credential');

        if (!empty($credential['new_password'])) {
            $updated = array_merge($credential, [
                'password' => $credential['new_password']
            ]);
            unset($updated['old_password'], $updated['new_password']);

            $this->merge([
                'credential' => $updated
            ]);
        }
    }

    /**
     * Validasi tambahan setelah rules utama dijalankan
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $credential = $this->input('credential');
            $accountId = $this->route('account');


            Log::info('credential', $credential);

            if (!empty($credential['new_password'])) {
                if (empty($credential['old_password'])) {
                    $validator->errors()->add('credential.old_password', 'Password saat ini dibutuhkan untuk mengganti password.');
                    return;
                }

                $verify = $this->account->verifyPassword([
                    'id' => $accountId,
                    'password' => $credential['old_password'],
                ]);

                Log::info('verify', [$verify]);

                if (!$verify['status']) {
                    $validator->errors()->add('credential.old_password', 'Password saat ini salah.');
                    return;
                }
                // Tambahkan field password baru dari credential.new_password
                $updated = array_merge($credential, [
                    'password' => $credential['new_password']
                ]);
                unset($updated['old_password'], $updated['new_password']);

                $this->replace(array_merge($this->all(), [
                    'credential' => $updated
                ]));
            }
        });
    }
}
