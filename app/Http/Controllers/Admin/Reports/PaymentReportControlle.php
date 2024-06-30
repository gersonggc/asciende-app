<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\{Installment, Payment, Client, Contract};

class PaymentReportControlle extends Controller
{

    public function index(Request $request)
    {   
        $filters = $request->query('filters', []);

        [$from, $to] = $this->initialDataRange($filters);

        $clients = Client::all()->pluck('full_name', 'id');

        $contracts = Contract::all()->pluck('code', 'id');

        $query = Payment::query();

        $query = $this->applyFilters($query, $filters);

        $payments = $query->with('installment', 'installment.contract')
                            ->orderBy('payment_date', 'asc')
                            ->paginate(15)
                            ->appends(['filters' => $filters]);
    
    
        return view('admin.reports.payments.base', compact('payments', 'from', 'to', 'clients', 'contracts'));
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
        // Filtrar por rango de fecha si está presente
        if (!empty($filters['range_date'])) {
            $dates = explode(' - ', $filters['range_date']);
            $datesFrom = Carbon::createFromFormat('d/m/Y', $dates[0]);
            $datesTo = Carbon::createFromFormat('d/m/Y', $dates[1]);

            $query->whereBetween('payment_date', [$datesFrom, $datesTo]);
        }else{
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $query->whereBetween('payment_date', [$startOfMonth, $endOfMonth]);
        }

        // Filtrar por client_id si está presente
        if (!empty($filters['client_id'])) {
            $query->whereHas('installment.contract.client', function($q) use ($filters) {
                $q->where('id', $filters['client_id']);
            });
        }

        // Filtrar por contract_id si está presente
        if (!empty($filters['contract_id'])) {
            $query->whereHas('installment.contract', function($q) use ($filters) {
                $q->where('id', $filters['contract_id']);
            });
        }

        return $query;
    }

}
