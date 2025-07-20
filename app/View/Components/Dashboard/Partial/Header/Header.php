<?php

namespace App\View\Components\Dashboard\Partial\Header;

use App\Models\Accounts\Accounts;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use stdClass;

class Header extends Component {

    private string $theme;
    private stdClass $session;

    public function __construct($theme, $session)
    {
        $this->theme = $theme;
        $this->session = $session;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('dashboard.'.$this->theme.'.partial.header', [ 'theme' => $this->theme, 'session' => $this->session ]);
    }
}
