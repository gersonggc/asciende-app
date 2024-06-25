<?php
namespace App\Observers;

use App\Models\{Installment, Payment};

class PaymentObserver
{
    public function created(Payment $payment)
    {
        $installment = $payment->installment;
        $contract = $installment->contract;

        if ($installment->pending_amount === 0.0) {
            $installment->status = 'PAID';
            $installment->payment_date = $payment->payment_date;
            $contract->end_date = $payment->payment_date;
        } elseif ($payment->amount > 0) {
            $installment->status = 'PARTIAL_PAID';
        }

        $installment->save();

        // Check if all installments for the contract are paid

        if ($contract->allPaid()) {
            $contract->status = 'ENDING';
            $contract->save();
        }
    }
}
