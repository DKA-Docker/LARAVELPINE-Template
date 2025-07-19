<?php

namespace App\View\Components\Dashboard\Partial\Header;

use App\Models\Accounts\Accounts;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use stdClass;

class Header extends Component {

    private string $theme;
    private stdClass $account;

    public function __construct($theme, $account)
    {
        $this->theme = $theme;
        $this->account = $account;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('dashboard.'.$this->theme.'.partial.header', [ 'theme' => $this->theme, 'account' => $this->account ]);
    }
}
