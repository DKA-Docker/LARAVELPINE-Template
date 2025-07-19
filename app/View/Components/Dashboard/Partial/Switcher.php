<?php

namespace App\View\Components\Dashboard\Partial;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Switcher extends Component {

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
        return view('dashboard.'.$this->theme.'.partial.switcher', [ 'theme' => $this->theme ]);
    }
}
