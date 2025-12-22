<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Requests\Creates;

use App\Services\Resources\Deliveries\Requests\ResourcesDeliveriesRequestsServices;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;


class Index extends Component
{

    protected ResourcesDeliveriesRequestsServices $services;
    /**
     * Data global form.
     */
    public array $data = [
        'name'        => null,
        'urgent'       => null,
        'destinations' => [], // ini akan di-bind ke child Destinations\ItemsLayout
    ];
    // Properti untuk mengecek izin tanpa throw error
    public bool $isAuthorized = true;

    public function boot()
    {
        $this->services = new ResourcesDeliveriesRequestsServices();
    }
    public function mount(): void
    {
        // Langsung lempar exception jika tidak punya izin
        if (!Auth::user()->can('dashboards.apps.deliveries.requests.create')) {
            $this->isAuthorized = false;
        }
    }

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
        // Jika tidak ada izin, langsung kembalikan view khusus unauthorized
        if (!$this->isAuthorized) {
            return view('dashboards.layouts.unauthorized');
        }
        return view('dashboards.apps.deliveries.requests.creates.index');
    }
}
