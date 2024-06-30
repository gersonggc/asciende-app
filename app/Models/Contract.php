<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\ContractObserver;

class Contract extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'code',
        'client_id',
        'guarantor_id',
        'initial_amount',
        'total_amount',
        'profit',
        'percentage',
        'initial',
        'payment_frequency',
        'installments_number',
        'payment_day_of_week',
        'status',
        'start_date',
        'end_date',
        'terms',
        'notes'
    ];

    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean',
        'start_date' => 'date'
    ];

    protected $appends = [
        'sumary_payment',
        'full_name',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function guarantor()
    {
        return $this->belongsTo(Client::class, 'guarantor_id');
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }

    public function getFullNameAttribute()
    {
        return $this->client->full_name;
    }

    public function getSumaryPaymentAttribute()
    {
        $pendingAmount = $this->installments->sum('pending_amount');
        $totalReceived = $this->installments->sum('total_payment');

        // return  $this->total_amount.' / '.$totalReceived . ' / '.$pendingAmount;


        return [
            'total_payment' => number_format($this->total_amount, 2),
            'total_received' => number_format($totalReceived, 2),
            'pending_amount' => number_format($pendingAmount, 2)
        ];
    }

    protected static function boot()
    {
        parent::boot();
        self::observe(ContractObserver::class);
    }

    public static function NextCode($clientCode)
    {
        $lastContract = self::where('code', 'like', "$clientCode%")
            ->orderBy('code', 'desc')
            ->value('code');

        if (!$lastContract) {
            return "$clientCode-CT-001";
        }

        $lastNumber = intval(substr($lastContract, -3));
        $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return "$clientCode-CT-$nextNumber";
    }

    public function allPending(): bool
    {
        return $this->installments()->where('status', '!=', 'PENDING')->doesntExist();
    }

    public function allPaid(): bool
    {
        return $this->installments()->where('status', '!=', 'PAID')->doesntExist();
    }

    public function getEditButton()
    {
        if ($this->allPending())
        {
            return '<a href="' . url('admin/contract/' . $this->getKey() . '/edit') . '" class="btn btn-sm btn-link"> <span><i class="la la-edit"></i> Editar</span></a>';
        }
    }

    public function getDeleteButton()
    {
        if ($this->allPending()) {
            $button = '<a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="' . url('admin/contract/' . $this->getKey()) . '"';
            $button .= ' class="btn btn-sm btn-link" data-button-type="delete">';
            $button .= '<span><i class="la la-trash"></i> Eliminar</span></a>';
            return $button;
        }
    }

}
