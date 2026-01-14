<?php

namespace App\Livewire\Metronic\Frontends\Auth\Components;

use App\Services\Resources\Accounts\ResourcesAccountsServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Register extends Component
{
    // Step state
    public int $currentStep = 1;

    // Step 1: Info
    public string $first_name = '';
    public string $last_name = '';

    // Step 2: Contact
    public string $email = '';
    public string $phone = '';

    // Step 3: Credentials
    public string $username = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected ResourcesAccountsServices $resourceService;

    public function boot(ResourcesAccountsServices $resourceService) {
        $this->resourceService = $resourceService;
    }

    public function render(): Factory|View
    {
        return view('frontends.auth.components.register');
    }

    public function nextStep()
    {
        $this->validateStep($this->currentStep);
        $this->currentStep++;
    }

    public function prevStep()
    {
        $this->currentStep--;
    }

    public function validateStep($step)
    {
        if ($step == 1) {
            $this->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['nullable', 'string', 'max:255'],
            ]);
        } elseif ($step == 2) {
            $this->validate([
                'email' => ['required', 'email', 'unique:accounts_contacts,email'],
                'phone' => ['nullable', 'string', 'max:20'],
            ]);
        } elseif ($step == 3) {
            $this->validate([
                'username' => ['required', 'string', 'min:3', 'unique:accounts_credentials,username'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);
        }
    }

    public function store()
    {
        $this->validateStep(3);

        $payload = [
            'information' => [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
            ],
            'contact' => [
                'email' => $this->email,
                'phone' => $this->phone,
            ],
            'credential' => [
                'username' => $this->username,
                'password' => $this->password,
            ],
            // Roles default to 'customer' inside the service if not provided,
            // but we can be explicit if needed. The service defaults to ['customer'].
        ];

        $result = $this->resourceService->Register($payload);

        if (!$result['status']) {
            $this->addError('errors', $result['msg']);
            return;
        }

        return redirect()->route('auth.index')->with('success', 'Registration successful! Please login.');
    }
}
