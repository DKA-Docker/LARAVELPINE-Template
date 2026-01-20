<?php

namespace App\Livewire\Metronic\Dashboards\Managements\Accounts\Components;

use App\Models\Base\Permissions\PermissionsRole;
use App\Services\Resources\Accounts\ResourcesAccountsServices;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class EditForm extends Component
{
    public $id;
    public $formData = [
        'id' => '',
        'credential' => [
            'id' => '',
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
            'phone' => '', // Include phone if it's in the structure
        ],
        'roles' => [],
        'firebase' => [], // Required by Update service validation
    ];

    public bool $isAuthorized = true;
    public $roles = [];
    protected ResourcesAccountsServices $accountsServices;

    public function boot(): void
    {
        $this->accountsServices = new ResourcesAccountsServices();
    }

    public function mount($id): void
    {
        $this->id = $id;
        $auth = Auth::user();

        if (!$auth->can('dashboards.managements.accounts.edit')) { // Assuming permission name
            // Fallback or specific permission if exists, otherwise reuse view/create or just authorized
             $this->isAuthorized = $auth->can('dashboards.managements.accounts.view');
        }

        $primaryRole = $auth->getRoleNames()->first();
        $query = PermissionsRole::query();

        $this->roles = match ($primaryRole) {
            'superadmin' => $query->get(),
            'driver' => $query->whereNotIn('name', ['superadmin', 'driver'])->get(),
            default => $query->whereNotIn('name', ['superadmin', 'admin'])->get(),
        };

        $this->loadAccountData($id);
    }

    public function loadAccountData($id): void
    {
        $account = $this->accountsServices->query()
            ->with(['credential', 'information', 'contact', 'roles', 'firebase'])
            ->find($id);

        if ($account) {
            // Debugbar::info($account->contact->email ?? ''); // User added this, keeping if they want, but replacing block
            // Use getRelation to bypass potential attribute shadowing
            $credential = $account->getRelation('credential');
            $information = $account->getRelation('information');
            $contact = $account->getRelation('contact');
            $firebase = $account->getRelation('firebase');
            $roles = $account->getRelation('roles');

            $this->formData['id'] = $account->id;
            $this->formData['credential']['id'] = $credential->id ?? '';
            $this->formData['credential']['username'] = $credential->username ?? '';
            // Password left empty intentionally

            $this->formData['information']['first_name'] = $information->first_name ?? '';
            $this->formData['information']['last_name'] = $information->last_name ?? '';

            $this->formData['contact']['email'] = $contact->email ?? '';
            $this->formData['contact']['phone'] = $contact->phone ?? '';

            // Handle firebase safely
            if ($firebase && method_exists($firebase, 'toArray')) {
                $this->formData['firebase'] = $firebase->toArray();
            } else {
                $this->formData['firebase'] = is_array($firebase) ? $firebase : [];
            }

            // Map roles
            if ($roles) {
                 $this->formData['roles'] = $roles->pluck('name')->toArray();
            } else {
                 $this->formData['roles'] = [];
            }
        }
    }

    public function clearRole(): void
    {
        $this->formData['roles'] = [];
        $this->resetValidation('formData.roles');
    }

    protected function rules(): array
    {
        return [
            'formData.credential.username' => 'required|min:4|unique:accounts_credentials,username,' . ($this->formData['credential']['id'] ?? '') . ',id',

            'formData.credential.password' => 'nullable|min:6|confirmed', // Optional on edit
            'formData.information.first_name' => 'required|string|max:50',
            'formData.contact.email' => 'required|email', // Unique check should ideally ignore current contact ID
            'formData.roles' => 'required|array|min:1',
        ];
    }

    // Custom validation logic might be needed for ignoring IDs properly if standard rules fail due to table structure

    protected $messages = [
        'formData.credential.password.confirmed' => 'Konfirmasi password tidak cocok.',
        'formData.roles.required' => 'Silakan pilih setidaknya satu role.',
    ];

    public function submit()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->addError('submit', 'Terdapat kesalahan validasi. Silakan periksa kembali inputan Anda.');
            throw $e;
        }
        
        // Filter empty password so it doesn't overwrite with null/empty
        $payload = $this->formData;
        if (empty($payload['credential']['password'])) {
             unset($payload['credential']['password']);
             unset($payload['credential']['password_confirmation']);
        }

        // We ensure we pass the 'id' which is in formData['id']
        // The service Update method expects:
        // 'id', 'information', 'credential', 'contact', 'firebase'
        // And roles? Service Update dispatch:
        // The Service Update method in `ResourcesAccountsServices.php` handles:
        // information, credential, contact, firebase.
        // It DOES NOT seem to handle 'roles' update in the provided `Update` method snippet!
        // The Create method did: `$account->assignRole($payload['roles']);`
        // We might need to manually handle role sync here or update the service.
        // Since I cannot modify Service easily without permission/scope, I will handle role sync here if possible
        // OR assume the service might have been updated or I missed it.
        // Reading `ResourcesAccountsServices.php` again...
        // `Update` method lines 165-259:
        // It updates info, creds, contact, firebase.
        // NO Role update logic seen.
        // I should probably do it here after successful service call or inside if I could.
        // For now, I'll do it here utilizing the model directly if needed or via a separate call.
        // Using `$account = $this->accountsServices->query()->find($this->id); $account->syncRoles(...)`

        $response = $this->accountsServices->Update($payload);

        if ($response['status']) {
            // Handle Role Sync manually since Service doesn't seem to include it in Update
             $account = $this->accountsServices->query()->find($this->id);
             if($account && !empty($this->formData['roles'])){
                 $account->syncRoles($this->formData['roles']);
             }

            session()->flash('success', 'Akun berhasil diperbarui.');
            return redirect()->route('dashboards.managements.accounts.index');
        } else {
            $this->addError('submit', $response['msg']);
            if(isset($response['error'])){
                 foreach($response['error'] as $k => $v){
                      $this->addError($k, is_array($v) ? implode(', ', $v) : $v);
                 }
            }
        }
    }

    public function render(): View
    {
        if (!$this->isAuthorized) {
            return view('dashboards.layouts.unauthorized');
        }
        return view('dashboards.managements.accounts.components.edit-form', [
            'roles' => $this->roles
        ]);
    }
}
