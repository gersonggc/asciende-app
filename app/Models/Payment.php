<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\Observers\PaymentObserver;

class Payment extends Model
{
    use CrudTrait;
    
    protected $fillable = [
        'installment_id',
        'payment_date',
        'amount',
        'notes'
    ];


    protected $dates = [
        'payment_date'
    ];

    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }

    public function getInstallmentsButton()
    {
        // dd($this->getKey());
        
        return '<a href="' . url('admin/installments?contract_id=' . $this->installment?->contract_id) . '" class="btn btn-sm btn-link"> <span><i class="la la-eye"></i>Volver a Cuotas</span></a>';
    }

    protected static function boot()
    {
        parent::boot();
        self::observe(PaymentObserver::class);
    }
}
