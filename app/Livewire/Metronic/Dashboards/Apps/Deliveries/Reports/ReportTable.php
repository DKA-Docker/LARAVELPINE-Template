<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Reports;

use Barryvdh\Debugbar\Facades\Debugbar;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;


use Livewire\Attributes\Lazy;

#[Lazy]
class ReportTable extends Component
{
    use WithPagination;

    public $query = '';
    public $startDate;
    public $endDate;
    public $dateFilter = 'all';
    public $perPage = 10;

    public function placeholder()
    {
        return view('dashboards.layouts.placeholders.view');
    }

    public function setDateFilter($range)
    {
        $this->dateFilter = $range;
        $now = Carbon::now();

        switch ($range) {
            case 'this_month':
                $this->startDate = $now->copy()->startOfMonth()->toDateString();
                $this->endDate = $now->copy()->endOfMonth()->toDateString();
                break;
            case 'last_6_months':
                $this->startDate = $now->copy()->subMonths(6)->toDateString();
                $this->endDate = $now->copy()->toDateString();
                break;
            case 'this_year':
                $this->startDate = $now->copy()->startOfYear()->toDateString();
                $this->endDate = $now->copy()->endOfYear()->toDateString();
                break;
            case 'all':
                $this->startDate = null;
                $this->endDate = null;
                break;
        }
    }

    public function updated($property)
    {
        if ($property === 'startDate' || $property === 'endDate') {
            $this->dateFilter = 'custom';
            $this->resetPage();
        }

        if ($property === 'query' || $property === 'perPage') {
            $this->resetPage();
        }
    }

    public function render()
    {
        $reports = AppsDeliveriesTasks::query()
            ->with([
                'account',
                'assigns.assigned.information',
                'assigns.assigned.credential',
                'destination.packages',
                'destination.request.account.information',
                'history',
                'geos'
            ])
            ->when($this->query, function ($q) {
                $q->where('id', 'like', '%' . $this->query . '%')
                    ->orWhere('name', 'like', '%' . $this->query . '%');
            })
            ->when($this->startDate, fn($q) => $q->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate, fn($q) => $q->whereDate('created_at', '<=', $this->endDate))
            ->latest()
            ->paginate($this->perPage);

        // Memproses setiap item hasil paginasi
        $reports->through(function ($item) {
            // Ambil relasi asli yang sudah di-load (Eager Loaded)
            $destination = $item->getRelation('destination');

            if ($destination) {
                // Pastikan nested relations tetap terikat dengan benar
                $destination->setRelation('packages', $destination->getRelation('packages'));

                $request = $destination->getRelation('request');
                if ($request) {
                    $reqAccount = $request->getRelation('account');
                    if ($reqAccount) {
                        $reqAccount->setRelation('information', $reqAccount->getRelation('information'));
                        $request->setRelation('account', $reqAccount);
                    }
                    $destination->setRelation('request', $request);
                }

                // TIMPA kolom 'destination' (string) dengan object relasi
                $item->destination = $destination;
            }

            // Tangani relasi lain jika diperlukan agar tidak konflik dengan kolom
            $item->account = $item->getRelation('account');
            $item->history = $item->getRelation('history');

            return $item;
        });

        return view('dashboards.apps.deliveries.reports.report-table', [
            'reports' => $reports,
        ]);
    }

    public function exportPdf()
    {
        $reports = AppsDeliveriesTasks::query()
            ->with([
                'account',
                'assigns.assigned.information', // Load assignments via pivot model
                'assigns.assigned.credential', // Load credential for username fallback
                'destination.packages', // Load destination packages
                'destination.request.account.information', // Load detailed destination info matches Tasks View
                'history',
                'geos'
            ])
            ->when($this->query, function ($q) {
                $q->where('id', 'like', '%' . $this->query . '%')
                  ->orWhere('name', 'like', '%' . $this->query . '%');
            })
            ->when($this->startDate, fn(Builder $q) => $q->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate, fn(Builder $q) => $q->whereDate('created_at', '<=', $this->endDate))
            ->latest()
            ->get();

        // Manual Hydration to logic conflict and ensure objects are available
        // Matches App\Livewire\Metronic\Dashboards\Apps\Deliveries\Tasks\View.php logic
        $reports->map(function ($item) {
            $item->account = $item->getRelation('account');
            $item->history = $item->getRelation('history');

            // CRITICAL FIX: The 'destination' column (string) conflicts with 'destination' relationship.
            // We manually hydrate the relationship into 'destination_model' to be safe, while keeping 'destination' as is (string).
            // We also re-hydrate 'destinationData' alias just in case.
            $destRel = $item->getRelation('destinationData'); // Uses our alias
            if (!$destRel) {
                 // Fallback if alias wasn't loaded or is null, try getting the raw relation if possible, though 'destinationData' should be eager loaded
                 $destRel = $item->destinationData;
            }
            $item->destination_model = $destRel;

            // Deep hydration if needed (though eager load takes care of data presence, this aligns object structure)
            if ($item->destination_model) {
                 $item->destination_model->packages = $item->destination_model->getRelationValue('packages');
                 $item->destination_model->request = $item->destination_model->getRelationValue('request');
            }

            // Hydrate drivers
            $item->assigns = $item->getRelation('assigns');

            return $item;
        });

        $pdf = Pdf::loadView('exports.reports.pdf', [
            'reports' => $reports,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'delivery-reports-' . now()->format('Y-m-d') . '.pdf');
    }
}
