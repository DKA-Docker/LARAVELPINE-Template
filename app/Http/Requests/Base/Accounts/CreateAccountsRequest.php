<?php

namespace App\Http\Requests\Base\Accounts;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateAccountsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'information.first_name' => 'required|string',
            'information.last_name' => 'nullable|string',
            'credential.username' => 'required|string|min:6',
            'credential.password' => 'required|string|min:6',
            'credential.password_confirmation' => 'required|string|min:6',
            'contact.email' => 'required|email',
            'roles' => 'nullable|string'
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $data = $this->input('credential');
            if (($data['password'] ?? null) !== ($data['password_confirmation'] ?? null)) {
                $validator->errors()->add('credential.password', 'Password dan konfirmasi tidak sama.');
            }
        });
    }
}
