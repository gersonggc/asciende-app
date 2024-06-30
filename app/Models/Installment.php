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
        'projected_profit',
        'total_payment',
        'total_payment_list',
        'client',
        
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function getClientAttribute()
    {
        return $this->contract->client->full_name;
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

    public function getProjectedProfitAttribute()
    {
        $percentaje = $this->contract->percentage;
        $initialAmount = round($this->amount / (1 + $percentaje / 100), 2);

        return round($this->amount - $initialAmount, 2);
        
    }

    public function getPaymentsButton()
    {
        if ($this->status === 'PENDING')
        {
            return '';    
        }   

        return '<a href="' . url('admin/payment?installment_id=' . $this->getKey()) . '" class="btn btn-sm btn-link"> <span><i class="la la-eye"></i>Listado de Pagos</span></a>';
        
    }

    public function getPaymenInstallmentButton()
    {
        if (in_array($this->status, ['PENDING','PARTIAL_PAID']))
        {
            return '<a class="btn btn-sm btn-link" href="'.url('/admin/payment/create?installment_id='.$this->getKey()).'">
                <span class="badge rounded-pill text-bg-success"><i class="la la-check-circle me-2"></i> Pagar Cuota</span>
            </a>';
        }
    }




}
