<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Installment, Payment};
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index()
    {
        
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Obtener los pagos pendientes de la semana en curso
        $pendingPayments = Installment::whereBetween('due_date', [$startOfWeek, $endOfWeek])
                       ->whereIn('status', ['PENDING', 'PARTIAL_PAID'])
                       ->get()
                       ->groupBy(function ($payment) {
                        return  ucfirst(Carbon::parse($payment->due_date)->isoFormat('dddd'));
                       });
        
        return view('dashboard', compact('pendingPayments'));
    }

    public function proyection(Request $request)
    {
        $range_date = $request->query('range_date','');

        [$from, $to] = $this->initialDataRange( $range_date );

        $queryInstallment = Installment::query();

        $queryPayment = Payment::query();

        [$installment, $payment] = $this->applyFilters($queryInstallment, $queryPayment, $range_date);

        $projectedProfit = $installment->sum('projected_profit');
                      
        $profitPayment = $payment->sum('profit');


        return view('admin.reports.proyection', compact('projectedProfit', 'profitPayment', 'from', 'to'));
    }

    private function initialDataRange( $range_date )
    {
        if( $range_date ){
            $dates = explode(' - ', $range_date);
            $from = Carbon::createFromFormat('d/m/Y', $dates[0])->format('d/m/Y');
            $to = Carbon::createFromFormat('d/m/Y', $dates[1])->format('d/m/Y');
        }else{
            $from = Carbon::now()->startOfMonth()->format('d/m/Y');
            $to   = Carbon::now()->endOfMonth()->format('d/m/Y');
        }

        return [$from, $to];
    }

    private function applyFilters($queryInstallment, $queryPayment, $range_date)
    {
        // Filtrar por rango de fecha si está presente
        if ($range_date) {
            $dates = explode(' - ', $range_date);
            $datesFrom = Carbon::createFromFormat('d/m/Y', $dates[0]);
            $datesTo = Carbon::createFromFormat('d/m/Y', $dates[1]);

            $installment = $queryInstallment->whereBetween('due_date', [$datesFrom, $datesTo])->get();
            $payment = $queryPayment->whereBetween('payment_date', [$datesFrom, $datesTo])->get();
        }else{
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $installment = $queryInstallment->whereBetween('due_date', [$startOfMonth, $endOfMonth])->get();
            $payment = $queryPayment->whereBetween('payment_date', [$startOfMonth, $endOfMonth])->get();
        }

        return [$installment, $payment];
    }
}
