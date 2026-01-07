<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Requests\Components\Edit;

use App\Services\Resources\Deliveries\Requests\ResourcesDeliveriesRequestsServices;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class Index extends Component
{

    public $requestId;

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
    public function mount($requestId): void
    {
        $this->requestId = $requestId;

        // Langsung lempar exception jika tidak punya izin
        if (!Auth::user()->can('dashboards.apps.deliveries.requests.view')) {
            $this->isAuthorized = false;
            return;
        }

        $this->loadRequestData();
    }

    protected function loadRequestData()
    {
        $request = $this->services->Find($this->requestId);

        if (!$request) {
            return;
        }

        $this->data['name'] = $request->name;
        $this->data['urgent'] = $request->urgent;

        if ($request->destinations) {
            foreach ($request->destinations as $destination) {
                $packages = [];
                if ($destination->packages) {
                    foreach ($destination->packages as $package) {
                        $packages[] = [
                            'name' => $package->content,
                            'qty' => $package->quantity,
                            'dimension_weight' => $package->volume_length, // View maps Length to dimension_weight
                            'dimension_width' => $package->volume_width,
                            'dimension_height' => $package->volume_height,
                            'heavy' => $package->weight,
                            'volume' => $package->volume,
                        ];
                    }
                }

                $this->data['destinations'][] = [
                    'id' => $destination->id,
                    'receipt_name' => $destination->receipt_name,
                    'receipt_address' => $destination->receipt_address,
                    'coordinate_latitude' => $destination->coordinate_latitude,
                    'coordinate_longitude' => $destination->coordinate_longitude,
                    'description' => $destination->description,
                    'packages' => $packages
                ];
            }
        }
    }

    public function submit()
    {
        Debugbar::info('SUBMIT PAYLOAD', $this->data);

        $response = $this->services->Update($this->requestId, $this->data);

        if ($response['status'] === true) {
            // redirect seperti sekarang + bawa flash message
            redirect()
                ->route('dashboards.apps.deliveries.requests.index')
                ->with([
                    'status'  => true,
                    'message' => $response['message'] ?? 'Berhasil memperbarui data request pengiriman.',
                ]);
            return;
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
        return view('dashboards.apps.deliveries.requests.components.edit.index');
    }
}
