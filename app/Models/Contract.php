<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'client_id',
        'guarantor_id',
        'amount',
        'payment_frequency',
        'installments',
        'percentage',
        'status',
        'start_date',
        'end_date',
        'terms',
        'notes'
    ];

    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function guarantor()
    {
        return $this->belongsTo(Client::class, 'guarantor_id');
    }

}
