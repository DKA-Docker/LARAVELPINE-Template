<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Tasks\Components;

use Illuminate\Http\Request;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class PackagesItemsLayout extends Component
{
    public array $items = [];

    public function mount(): void
    {
        // init 1 item default
        $this->items = [];
    }

    protected function defaultItem(): array
    {
        return [
            'name' => '',
            'qty' => 0,
            'unit' => '',
            'width' => 0,
            'height' => 0,
            'weight' => 0,
            'heavy' => 0,
            'price' => 0,
            'address' => '',
            'lat' => null,
            'lng' => null,
        ];
    }

    public function add(): void
    {
        $this->items[] = $this->defaultItem();

        // kasih tau JS kalau DOM items berubah
        $this->dispatch('packages-items-updated');
    }

    public function remove(int $index): void
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);

        $this->dispatch('packages-items-updated');
    }

    /**
     * Jaga supaya numeric nggak minus.
     */
    public function updated($name): void
    {
        if (!str_starts_with($name, 'items.')) {
            return;
        }

        $parts = explode('.', $name);
        $field = $parts[array_key_last($parts)];

        // HANYA field yang benar-benar nggak boleh minus
        $protected = ['qty', 'width', 'height', 'weight', 'heavy', 'price'];

        if (!in_array($field, $protected, true)) {
            return;
        }

        $value = (float)data_get($this, $name);

        if ($value < 0) {
            // Livewire v3 nggak ada $this->set(), pakai data_set
            data_set($this, $name, 0);
        }
    }

    public function simpan(Request $request): void
    {
        $this->items[] = $this->defaultItem();

        // kasih tau JS kalau DOM items berubah
        $this->dispatch('packages-items-updated');
        // kasih tau JS kalau DOM items berubah
    }


    public function render()
    {
        return view('dashboards.apps.deliveries.tasks.components.packages-items-layout');
    }
}
