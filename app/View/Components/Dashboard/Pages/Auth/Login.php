<?php

namespace App\View\Components\Dashboard\Pages\Auth;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Login extends Component {

    private string $theme;

    public function __construct($theme)
    {
        $this->theme = $theme;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('dashboard.'.$this->theme.'.pages.auth.login', [ 'theme' => $this->theme ]);
    }
}
