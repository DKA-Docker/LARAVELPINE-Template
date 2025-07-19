<?php

namespace App\View\Components\Dashboard\Pages\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dashboard extends Component {

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
        return view('dashboard.'.$this->theme.'.pages.dashboard.dashboard', [ 'theme' => $this->theme ]);
    }
}
