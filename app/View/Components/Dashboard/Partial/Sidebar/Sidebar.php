<?php

namespace App\View\Components\Dashboard\Partial\Sidebar;

use App\Repositories\Apps\Dashboards\Configurations\AppsDashboardsConfigurationsMenusRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Collection;

class Sidebar extends Component
{
    private string $theme;
    private object $account;
    private AppsDashboardsConfigurationsMenusRepository $menuRepository;

    public function __construct(null|string $theme, object $session)
    {
        $this->theme = $theme;
        $this->session = $session;
        $this->menuRepository = new AppsDashboardsConfigurationsMenusRepository();
    }

    /**
     * Render the sidebar view with nested menus.
     */
    public function render(): View|Closure|string
    {
        $menus = $this->menuRepository->ReadAll();

        // Bangun struktur section -> parent -> child
        $sections = [];

        foreach ($menus->where('type', 'heading') as $heading) {
            $section = (object)[
                'heading' => $heading->name,
                'items' => []
            ];

            // Ambil parent-menu yang section_order == heading id
            $parents = $menus->where('parent', null)->where('section_order', $heading->id)->values();

            foreach ($parents as $parent) {
                $parent->children = $menus->where('parent', $parent->id)->values();
                $section->items[] = $parent;
            }

            $sections[] = $section;
        }

        return view("dashboard.$this->theme.partial.sidebar", [
            'theme' => $this->theme,
            'session' => $this->session,
            'sections' => $sections
        ]);
    }

    /**
     * Build a nested tree of menus from a flat list.
     */
    private function buildMenuTree(Collection $menus, $parentId = null): array
    {
        $branch = [];

        foreach ($menus as $menu) {
            if ($menu->parent === $parentId) {
                $children = $this->buildMenuTree($menus, $menu->id);
                $menu->children = $children;
                $branch[] = $menu;
            }
        }

        return $branch;
    }
}
