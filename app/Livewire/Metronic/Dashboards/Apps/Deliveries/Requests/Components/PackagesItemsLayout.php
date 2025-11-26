<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Requests\Components;

use Livewire\Component;

class PackagesItemsLayout extends Component
{
    public array $items = [];

    public function mount(): void
    {
        // Minimal 1 baris awal
        $this->items = [
            [
                'name'   => '',
                'qty'    => 0,
                'price'  => 0,
                'unit'   => '',
                'width'  => null,
                'height' => null,
                'weight' => null,
                'heavy'  => null,
            ],
        ];
    }

    public function add(): void
    {
        $this->items[] = [
            'name'   => '',
            'qty'    => 1,
            'price'  => 0,
            'unit'   => '',
            'width'  => null,
            'height' => null,
            'weight' => null,
            'heavy'  => null,
        ];
    }

    public function remove(int $index): void
    {
        unset($this->items[$index]);

        // Reindex agar binding Livewire tetap rapi (0,1,2,...)
        $this->items = array_values($this->items);
    }

    public function render()
    {
        return view('dashboards.apps.deliveries.requests.components.packages-items-layout');
    }
}
