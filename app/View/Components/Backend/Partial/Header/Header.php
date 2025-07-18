<?php

namespace App\View\Components\Backend\Partial\Header;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component {

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
        return view('backend.'.$this->theme.'.partial.header');
    }
}
