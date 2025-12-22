<?php

namespace App\Livewire\Metronic\Dashboards\Managements\Accounts\Components;

use App\Models\Base\Permissions\PermissionsRole;
use App\Services\Resources\Accounts\ResourcesAccountsServices;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
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
        'role' => [], // Inisialisasi sebagai array untuk multi-select
    ];

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
            throw new AuthorizationException("Izin Ditolak.");
        }

        /** * MENGAMBIL ROLE UTAMA SEBAGAI STRING
         * Jika menggunakan Spatie: $auth->getRoleNames()->first()
         * Jika menggunakan relasi manual: $auth->roles->first()->name ?? ''
         */
        $primaryRole = $auth->getRoleNames()->first();

        Debugbar::info("Primary Role untuk switch: " . $primaryRole);

        $query = PermissionsRole::query();

        switch ($primaryRole) {
            case 'superadmin':
                // Superadmin bisa melihat dan membuat semua role
                $this->roles = $query->get();
                break;

            case 'admin':
                // Admin tidak boleh melihat/membuat superadmin
                $this->roles = $query->whereNotIn('name', ['superadmin', 'admin'])->get();
                break;

            case 'driver':
                // Driver tidak boleh membuat superadmin dan sesama driver
                $this->roles = $query->whereNotIn('name', ['superadmin', 'driver'])->get();
                break;

            default:
                // Default: hanya tampilkan role yang umum (opsional)
                $this->roles = $query->whereNotIn('name', ['superadmin', 'admin'])->get();
                break;
        }
    }

    /**
     * Membersihkan pilihan role.
     * Menggunakan array kosong agar in_array di Blade tidak error.
     */
    public function clearRole(): void
    {
        Debugbar::log("clear role clicked");
        $this->formData['role'] = [];
        $this->resetValidation('formData.role');
    }


    public function updated(): void
    {
        Debugbar::info($this->formData);
    }

    protected function rules(): array
    {
        return [
            'formData.credential.username' => 'required|min:4|unique:apps_credentials,username',
            'formData.credential.password' => 'required|min:6|confirmed',
            'formData.information.first_name' => 'required|string|max:50',
            'formData.contact.email' => 'required|email|unique:apps_contacts,email',
            'formData.role' => 'required|array|min:1',
        ];
    }

    protected $messages = [
        'formData.credential.password.confirmed' => 'Konfirmasi password tidak cocok.',
        'formData.role.required' => 'Silakan pilih setidaknya satu role.',
    ];

    public function submit()
    {
        $this->validate();

        try {
            $response = $this->accountsServices->Create($this->formData);

            if ($response['status']) {
                session()->flash('success', 'Akun berhasil dibuat.');
                return redirect()->route('dashboards.managements.accounts.index');
            }

            $this->addError('submit', 'Gagal menyimpan data.');
        } catch (\Exception $e) {
            Debugbar::error($e->getMessage());
            $this->addError('submit', 'Error: ' . $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('dashboards.managements.accounts.components.create-form', [
            'roles' => $this->roles
        ]);
    }
}
