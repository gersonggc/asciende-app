<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'code',
        'dni',
        'names',
        'last_names',
        'direction',
        'phone',
        'email',
        'active'
    ];

    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean',
    ];

    protected $appends = [
        'name_code',
        
    ];

    public function toString()
    {
        return $this->name_code;
    }

    public function getNameCodeAttribute()
    {
        return trim($this->names).'-'.$this->code;
    }


    public function scopeStatus($query, $status=true)
    {
        return $query->where('active', $status);
    }

    public static function getOptions()
    {
        return self::Status(true)
            ->get()
            ->mapWithKeys(function ($client) {
                return [$client->id => $client->name_code];
            })
            ->toArray();
    }
}
