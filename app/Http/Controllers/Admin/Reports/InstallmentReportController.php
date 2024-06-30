<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\{Installment, Payment, Client, Contract};

class InstallmentReportController extends Controller
{
    const STATUS_CLASSES = [
        'PAID' => 'badge rounded-pill text-bg-success',
        'PARTIAL_PAID' => 'badge rounded-pill text-bg-warning',
        'ENDING' => 'badge rounded-pill text-bg-warning',
        'REJECTED' => 'badge rounded-pill text-bg-danger',
        'PENDING' => 'badge rounded-pill text-bg-info'
    ];

    public function index(Request $request)
    {   
     
        $statusClass = self::STATUS_CLASSES;

        $statuses = Installment::STATUSES;

        $clients = Client::all()->pluck('full_name', 'id');

        $contracts = Contract::all()->pluck('code', 'id');
        
        $filters = $request->query('filters', []);

        [$from, $to] = $this->initialDataRange($filters);

        $query = Installment::query();

        $query = $this->applyFilters($query, $filters);

        $installments = $query->with('payments', 'contract', 'contract.client')
                            ->orderBy('due_date', 'asc')
                            ->paginate(15)
                            ->appends(['filters' => $filters]);
    

        
        return view('admin.reports.installments.base', compact('installments', 'statusClass', 'from', 'to', 'statuses', 'clients', 'contracts'));
    }

    private function initialDataRange( $filters )
    {
        if( isset($filters['range_date'])  ){
            $dates = explode(' - ', $filters['range_date']);
            $from = Carbon::createFromFormat('d/m/Y', $dates[0])->format('d/m/Y');
            $to = Carbon::createFromFormat('d/m/Y', $dates[1])->format('d/m/Y');
        }else{
            $from = Carbon::now()->startOfMonth()->format('d/m/Y');
            $to   = Carbon::now()->endOfMonth()->format('d/m/Y');
        }

        return [$from, $to];
    }

    private function applyFilters($query, $filters)
    {
         
        if (!empty($filters['range_date'])) {
            $dates = explode(' - ', $filters['range_date']);
            $datesFrom = Carbon::createFromFormat('d/m/Y', $dates[0]);
            $datesTo = Carbon::createFromFormat('d/m/Y', $dates[1]);

            $query->whereBetween('due_date', [$datesFrom, $datesTo]);
        }else{
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $query->whereBetween('due_date', [$startOfMonth, $endOfMonth]);
        }

        // Filtrar por client_id si está presente
        if (!empty($filters['client_id'])) {
            $query->whereHas('contract.client', function($q) use ($filters) {
                $q->where('id', $filters['client_id']);
            });
        }

        // Filtrar por contract_id si está presente
        if (!empty($filters['contract_id'])) {
            $query->where('contract_id', $filters['contract_id']);
        }

        // Filtrar por estatus si está presente
        if (!empty($filters['status'])) {
            $query->whereIn('status', (array)$filters['status']);
        }

        return $query;
    }

}
