<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Requests\Creates\Destinations;

use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\Attributes\Lazy;

// #[Lazy]
class ItemsLayout extends Component
{
    #[Modelable]
    public array $destinations = [];

    /** Menyimpan status open/close per index: [0 => true, 1 => false, ...] */
    public array $open = [];

    protected function defaultItem(): array
    {
        return [
            'receipt_name'    => null,
            'receipt_address' => null,
            'description'     => null,
            'packages'        => [],   // <— nested packages di sini
        ];
    }

    /*public function mount(): void
    {
        // Kalau parent belum ngasih apa-apa, init 1 tujuan default
        if (empty($this->destinations)) {
            $this->destinations[] = $this->defaultItem();
        }

        // Pastikan minimal index 0 kebuka
        foreach ($this->destinations as $i => $_) {
            $this->open[$i] = $this->open[$i] ?? ($i === 0);
        }
    }*/

    public function add(): void
    {

        Debugbar::info();
        $this->destinations[] = $this->defaultItem();

        // Biar index align, dan item terakhir auto kebuka
        $lastIndex = array_key_last($this->destinations);

        // Mode accordion: cuma satu kebuka
        $this->open = [];

        foreach ($this->destinations as $i => $_) {
            $this->open[$i] = $i === $lastIndex;
        }
    }

    public function delete(int $index): void
    {
        Debugbar::info($index);
        unset($this->destinations[$index], $this->open[$index]);

        // Reindex array biar Blade dan state sinkron
        $this->destinations = array_values($this->destinations);
        $this->open     = array_values($this->open);

        // Kalau masih ada item, pastikan minimal index 0 kebuka
        if (count($this->destinations) && !isset($this->open[0])) {
            $this->open[0] = true;
        }
    }

    public function toggle(int $index): void
    {
        $current = $this->open[$index] ?? false;

        foreach ($this->destinations as $i => $_) {
            $this->open[$i] = false;
        }

        $this->open[$index] = !$current;
    }

    public function render()
    {
        return view('dashboards.apps.deliveries.requests.creates.destinations.items-layout');
    }
}
