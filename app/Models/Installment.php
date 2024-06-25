<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\InstallmentObserver;


class Installment extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'due_date',
        'amount',
        'amount_payment',
        'status',
        'payment_date',
        'notes',
        'installment_number'
    ];

    protected $dates = [
        'due_date',
        'payment_date',
    ];

    const STATUSES = [
        'PENDING' => 'Pendiente',
        'PAID' => 'Pagado',
        'PARTIAL_PAID' => 'Pagado Parcialmente',
        'NO_PAID' => 'No Pagado',
    ];

    protected $appends = [
        'pending_amount',
        'total_payment',
        'total_payment_list'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getPendingAmountAttribute()
    {
        $receivedAmount = $this->payments()->sum('amount');
        $pendingAmount = $this->amount - $receivedAmount;
        return (Float) $pendingAmount;
    }

    public function getTotalPaymentAttribute()
    {
        return $this->payments()->sum('amount');
    }

    public function getTotalPaymentListAttribute()
    {
        return $this->total_payment.' / '.$this->amount;
    }

    public function getPaymentsButton()
    {
        
        
        return '<a href="' . url('admin/payment?installment_id=' . $this->getKey()) . '" class="btn btn-sm btn-link"> <span><i class="la la-eye"></i>Listado de Pagos</span></a>';
        
    }

}
