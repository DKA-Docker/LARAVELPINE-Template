<?php

namespace App\Livewire\Metronic\Dashboards\Apps\Deliveries\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Apps\Deliveries\Tasks\AppsDeliveriesTasks;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ReportTable extends Component
{
    use WithPagination;

    public $query = '';
    public $startDate;
    public $endDate;
    public $dateFilter = 'all';

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
        }
    }

    public function render()
    {
        $reports = AppsDeliveriesTasks::query()
            ->with([
                'account',
                'assigns.assignedAccount.information', // Load assignments via pivot model
                'assigns.assignedAccount.credential', // Load credential for username fallback
                'destinationData.packages', // Load destination packages
                'destinationData.request.account.information', // Load detailed destination info matches Tasks View
                'history',
                'geos'
            ]) // Eager load for performance
            ->when($this->query, function ($q) {
                $q->where('id', 'like', '%' . $this->query . '%')
                  ->orWhere('name', 'like', '%' . $this->query . '%');
            })
            ->when($this->startDate, fn(Builder $q) => $q->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate, fn(Builder $q) => $q->whereDate('created_at', '<=', $this->endDate))
            ->latest() // default sort
            ->paginate(10);

        return view('dashboards.apps.deliveries.reports.report-table', [
            'reports' => $reports
        ]);
    }

    public function exportPdf()
    {
        $reports = AppsDeliveriesTasks::query()
            ->with([
                'account',
                'assigns.assignedAccount.information',
                'assigns.assignedAccount.credential',
                'destinationData.packages',
                'destinationData.request.account.information',
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
