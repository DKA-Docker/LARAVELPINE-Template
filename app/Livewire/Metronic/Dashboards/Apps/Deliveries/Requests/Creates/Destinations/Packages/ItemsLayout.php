<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Requests\Creates\Destinations\Packages;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class ItemsLayout extends Component
{
    #[Modelable]
    public array $packages = [];

    public array $open = [];

    protected function defaultItem(): array
    {
        return [
            'name'    => null,
            'qty'     => 0,
            'width'   => 0,
            'height'  => 0,
            'weight'  => 0,
            'heavy'   => 0
        ];
    }

    /*public function mount(): void
    {
        if (!count($this->packages)) {
            $this->add();
        }
    }*/

    public function add(): void
    {
        $this->packages[] = $this->defaultItem();

        $lastIndex = array_key_last($this->packages);

        $this->open = [];
        foreach ($this->packages as $i => $_) {
            $this->open[$i] = $i === $lastIndex;
        }
    }

    public function delete(int $index): void
    {
        unset($this->packages[$index], $this->open[$index]);

        $this->packages = array_values($this->packages);
        $this->open     = array_values($this->open);

        if (count($this->packages) && !isset($this->open[0])) {
            $this->open[0] = true;
        }
    }

    public function toggle(int $index): void
    {
        $current = $this->open[$index] ?? false;

        foreach ($this->packages as $i => $_) {
            $this->open[$i] = false;
        }

        $this->open[$index] = !$current;
    }

    public function updated($name): void
    {
        // optional: jaga supaya numeric nggak minus
        if (!str_starts_with($name, 'packages.')) {
            return;
        }

        $parts = explode('.', $name);
        $field = $parts[array_key_last($parts)];

        $protected = ['qty', 'width', 'height', 'weight', 'heavy'];

        if (!in_array($field, $protected, true)) {
            return;
        }

        $value = (float) data_get($this, $name);

        if ($value < 0) {
            data_set($this, $name, 0);
        }
    }

    public function render()
    {
        return view('dashboards.apps.deliveries.requests.creates.destinations.packages.items-layout');
    }
}
