<?php

namespace App\Observers;

use App\Models\Contract;
use App\Models\Installment;
use Carbon\Carbon;

class ContractObserver
{
    /**
     * Handle the Contract "created" event.
     */
    public function created(Contract $contract): void
    {   
        collect($this->installmentDueDates($contract))->each(function ($dueDate, $key) use ($contract) {
            $instalment =  Installment::create([
                'contract_id' => $contract->id,
                'installment_number' => $this->instalmentNumber($contract, $key),
                'due_date' => $dueDate,
                'amount' => $this->calculateAmountInstallment($contract),
                'status' => 'PENDING',
            ]);

        });
        
    }

    protected function instalmentNumber($contract, $key)
    {
        return $contract->code . ' - Cuota ' . ($key + 1) . ' de ' . $contract->installments_number;
    }

    protected function calculateAmountInstallment(Contract $contract): float
    {
        $totalAmount = $contract->total_amount - $contract->initial;
        $installmentAmount = $totalAmount / $contract->installments_number;
    
        return round($installmentAmount, 2);
    }
    protected function installmentDueDates(Contract $contract): array
    {
        $dueDates = [];
        $currentDate = $contract->start_date;
        $numInstallments = $contract->installments_number;
        $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        switch ($contract->payment_frequency) {
            case 'WEEKLY':
                $dayOfWeek = $contract->payment_day_of_week;
                $nameDayOfWeek = $daysOfWeek[$dayOfWeek];
                $dueDate = $currentDate->modify($dayOfWeek === $currentDate->format('N') ? 'this '.$nameDayOfWeek : 'next '.$nameDayOfWeek)
                    ->format('Y-m-d');
                for ($i = 1; $i <= $numInstallments; $i++) {
                    $dueDates[] = $dueDate;
                    $dueDate = Carbon::createFromFormat('Y-m-d', $dueDate)->addWeek()->toDateString();
                }
                break;
            case 'FORTNIGHTLY':
                for ($i = 1; $i <= $numInstallments; $i++) {
                    $dueDate = $currentDate->copy();
                    if ($i === 1) {
                        // $dueDate = $dueDate->day <= 15 ? $dueDate->day(15) : $dueDate->endOfMonth();
                        $dueDate = $dueDate->day <= 15 ? $dueDate->day(1) : $dueDate->day(16);
                    } else {
                        // $prevDate = Carbon::createFromFormat('Y-m-d', end($dueDates));
                        // $dueDate = $prevDate->day === 15 ? $prevDate->endOfMonth() : $prevDate->addDay()->day(15);
                        $prevDate = Carbon::createFromFormat('Y-m-d', end($dueDates));
                        // Si el pago anterior fue el día 16, entonces el próximo será el día 1 del siguiente mes, de lo contrario el día 16 del siguiente mes
                        $dueDate = $prevDate->day === 16 ? $prevDate->addMonth()->startOfMonth() : $prevDate->addMonth()->day(16);
                    }
                    $dueDates[] = $dueDate->toDateString();
                }
                break;
            default:
                for ($i = 1; $i <= $numInstallments; $i++) {
                    $dueDates[] = $currentDate->copy()->endOfMonth()->toDateString();
                    $currentDate = $currentDate->addMonth();
                }
        }

        return $dueDates;
    }


    /**
     * Handle the Contract "updated" event.
     */
    public function updated(Contract $contract): void
    {
        //
    }

    /**
     * Handle the Contract "deleted" event.
     */
    public function deleted(Contract $contract): void
    {
        //
    }

    /**
     * Handle the Contract "restored" event.
     */
    public function restored(Contract $contract): void
    {
        //
    }

    /**
     * Handle the Contract "force deleted" event.
     */
    public function forceDeleted(Contract $contract): void
    {
        //
    }
}
