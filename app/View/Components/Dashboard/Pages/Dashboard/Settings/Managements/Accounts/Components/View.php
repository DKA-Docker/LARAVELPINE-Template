<?php

namespace App\View\Components\Dashboard\Pages\Dashboard\Settings\Managements\Accounts\Components;

use App\Http\Controllers\Dashboard\Settings\Managements\Accounts\Accounts;
use App\Services\Resources\ResourcesAccountsServices;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;
use stdClass;

class View extends Component {

    private string $theme;
    protected stdClass $account;
    private stdClass $session;

    public function __construct($theme, $session, $account)
    {
        $this->theme = $theme;
        $this->account = $account;
        $this->session = $session;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        Log::info('view data', [$this->account]);
        return view('dashboard.'.$this->theme.'.pages.dashboard.settings.managements.accounts.components.view', [
            'theme' => $this->theme,
            'account' => $this->account,
            'session' => $this->session
        ]);
    }
}
