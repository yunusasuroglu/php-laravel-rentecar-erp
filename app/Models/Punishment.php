<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Punishment extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'contract_id',
        'customer_id',
        'car_id',
        'car',
        'driver',
        'punishment',
        'description'
    ];
    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function contract()
    {
        return $this->hasMany(Contract::class);
    }
}
