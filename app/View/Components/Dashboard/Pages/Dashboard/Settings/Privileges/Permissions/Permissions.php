<?php

namespace App\View\Components\Dashboard\Pages\Dashboard\Settings\Privileges\Permissions;

use App\Services\Resources\ResourcesAccountsServices;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use stdClass;

class Permissions extends Component {

    private string $theme;
    protected ResourcesAccountsServices $account;
    private stdClass $session;

    public function __construct($theme, $session)
    {
        $this->theme = $theme;
        $this->account = new ResourcesAccountsServices();
        $this->session = $session;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('dashboard.'.$this->theme.'.pages.dashboard.settings.privileges.permissions.permissions', [
            'theme' => $this->theme,
            'account' => $this->account,
            'session' => $this->session
        ]);
    }
}
