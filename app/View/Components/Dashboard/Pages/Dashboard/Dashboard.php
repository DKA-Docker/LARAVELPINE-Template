<?php

namespace App\View\Components\Dashboard\Pages\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use stdClass;

class Dashboard extends Component {

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
        return view('dashboard.'.$this->theme.'.pages.dashboard.dashboard', [ 'theme' => $this->theme, 'session' => $this->session ]);
    }
}
