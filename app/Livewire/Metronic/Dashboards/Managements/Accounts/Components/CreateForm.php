<?php

namespace App\Livewire\Metronic\Dashboards\Managements\Accounts\Components;

use App\Models\Base\Permissions\PermissionsRole;
use App\Services\Resources\Accounts\ResourcesAccountsServices;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;

class CreateForm extends Component
{
    public $formData = [
        'credential' => [
            'username' => '',
            'password' => '',
            'password_confirmation' => '',
        ],
        'information' => [
            'first_name' => '',
            'last_name' => '',
        ],
        'contact' => [
            'email' => '',
        ],
        'roles' => [], // DIUBAH: diselaraskan dengan Service (roles bukan role)
    ];

    public bool $isAuthorized = true;
    public $roles = [];
    protected ResourcesAccountsServices $accountsServices;

    public function boot(): void
    {
        $this->accountsServices = new ResourcesAccountsServices();
    }

    public function mount(): void
    {
        $auth = Auth::user();

        if (!$auth->can('dashboards.managements.accounts.create')) {
            $this->isAuthorized = false;
        }

        $primaryRole = $auth->getRoleNames()->first();
        $query = PermissionsRole::query();

        $this->roles = match ($primaryRole) {
            'superadmin' => $query->get(),
            'driver' => $query->whereNotIn('name', ['superadmin', 'driver'])->get(),
            default => $query->whereNotIn('name', ['superadmin', 'admin'])->get(),
        };
    }

    public function clearRole(): void
    {
        $this->formData['roles'] = []; // DIUBAH: reset ke array kosong
        $this->resetValidation('formData.roles');
    }

    protected function rules(): array
    {
        return [
            'formData.credential.username' => 'required|min:4|unique:apps_credentials,username',
            'formData.credential.password' => 'required|min:6|confirmed',
            'formData.information.first_name' => 'required|string|max:50',
            'formData.contact.email' => 'required|email|unique:apps_contacts,email',
            'formData.roles' => 'required|array|min:1', // DIUBAH: validasi array roles
        ];
    }

    protected $messages = [
        'formData.credential.password.confirmed' => 'Konfirmasi password tidak cocok.',
        'formData.roles.required' => 'Silakan pilih setidaknya satu role.',
    ];

    public function submit()
    {
        $response = $this->accountsServices->Create($this->formData);

        if ($response['status']) {
            session()->flash('success', 'Akun berhasil dibuat.');
            return redirect()->route('dashboards.managements.accounts.index');
        } else {
            $this->addError('submit', $response['msg']);
        }
    }

    public function render(): View
    {
        if (!$this->isAuthorized) {
            return view('dashboards.layouts.unauthorized');
        }
        return view('dashboards.managements.accounts.components.create-form', [
            'roles' => $this->roles
        ]);
    }
}
