<?php

namespace App\Livewire\Metronic\Frontends\Auth\Components;

use App\Services\Auth\AuthAccountsServices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class ForgotPassword extends Component
{
    public string $email = '';

    protected AuthAccountsServices $authService;

    public function boot(AuthAccountsServices $authService)
    {
        $this->authService = $authService;
    }

    public function render(): Factory|View
    {
        return view('frontends.auth.components.forgot-password');
    }

    public function submit()
    {
        $this->validate([
            'email' => 'required|email|exists:accounts_contacts,email',
        ]);

        $result = $this->authService->sendResetLink($this->email);

        if ($result['status']) {
            session()->flash('success', $result['msg']);
            $this->reset('email');
        } else {
            $this->addError('email', $result['msg']);
        }
    }
}
