<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Requests\Creates;

use App\Services\Resources\Deliveries\Requests\ResourcesDeliveriesRequestsServices;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{

    protected ResourcesDeliveriesRequestsServices $services;
    public function __construct()
    {
        $this->services = new ResourcesDeliveriesRequestsServices();
    }
    /**
     * Data global form.
     */
    public array $data = [
        'name'        => null,
        'urgent'       => null,
        'destinations' => [], // ini akan di-bind ke child Destinations\ItemsLayout
    ];

    public function submit()
    {
        Debugbar::info('SUBMIT PAYLOAD', $this->data);

        $response = $this->services->Create($this->data);

        if ($response['status'] === true) {
            // redirect seperti sekarang + bawa flash message
            redirect()
                ->route('dashboards.apps.deliveries.requests.index')
                ->with([
                    'status'  => true,
                    'message' => $response['message'] ?? 'Berhasil membuat data request pengiriman.',
                ]);
        }

        // kalau error: tampilkan di form Livewire
        $this->addError('form', $response['message'] ?? 'Terjadi kesalahan saat menyimpan data.');

        // opsional: kalau mau juga pakai session flash error
        session()->flash('status', false);
        session()->flash('message', $response['message'] ?? 'Terjadi kesalahan saat menyimpan data.');
    }


    public function render(): Factory|View
    {
        return view('dashboards.apps.deliveries.requests.creates.index');
    }
}
