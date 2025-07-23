<?php

namespace App\View\Components\Dashboard\Partial;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use stdClass;

class Breadcrumb extends Component {

    private string $theme;
    private stdClass $breadcrumb;

    public function __construct($theme)
    {
        $this->theme = $theme;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        $breadcrumbs = collect(request()->segments())
            ->reduce(function ($carry, $segment) {
                $slashUrl = ($carry->last()->url ?? '') . '/' . $segment;
                $dotRoute = ($carry->last()->route ?? '')
                    ? $carry->last()->route . '.' . $segment
                    : $segment;

                return $carry->push((object)[
                    'label' => ucfirst(str_replace('-', ' ', $segment)),
                    'url'   => $slashUrl,
                    'route' => $dotRoute,
                ]);
            }, collect());

        return view('dashboard.'.$this->theme.'.partial.breadcrumb', [
            'theme' => $this->theme,
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
