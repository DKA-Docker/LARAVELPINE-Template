<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Requests\Components;

use Livewire\Component;

class PackagesItemsLayout extends Component
{
    public array $items = [];

    public function mount(): void
    {
        $this->items = [
            [
                'name'   => '',
                'qty'    => 0,
                'width'  => 0,
                'height' => 0,
                'weight' => 0,
                'heavy'  => 0,
                'price'  => 0,
            ],
        ];
    }

    public function add(): void
    {
        $this->items[] = [
            'name'   => '',
            'qty'    => 0,
            'width'  => 0,
            'height' => 0,
            'weight' => 0,
            'heavy'  => 0,
            'price'  => 0,
        ];
    }

    public function remove(int $index): void
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    /**
     * Hook setiap field berubah (Livewire v2 & v3 kompatibel).
     * Di sini kita paksa semua numeric tertentu minimal 0.
     */
    public function updated($name): void
    {
        // hanya proses property "items.*"
        if (!str_starts_with($name, 'items.')) {
            return;
        }

        // ambil field terakhir, contoh:
        //  items.0.qty -> qty
        $parts = explode('.', $name);
        $field = $parts[array_key_last($parts)];

        $protectedFields = ['qty', 'width', 'height', 'weight', 'heavy'];

        if (!in_array($field, $protectedFields, true)) {
            return;
        }

        $value = (float) data_get($this, $name);

        if ($value < 0) {
            // paksa jadi 0 kalau minus
            $this->set($name, 0);
        }
    }

    public function render()
    {
        return view('dashboards.apps.deliveries.requests.components.packages-items-layout');
    }
}
