<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer',
        'items',
        'extra_km',
        'extra_km_price',
        'note',
        'km_packages',
        'insurance_packages',
        'discount',
        'tax',
        'subtotalprice',
        'company_id',
        'contract_id',
        'customer_id',
        'totalprice',
        'totalamount',
        'payment_status',
        'status',
        'damages',
    ];
    protected $casts = [
        'items' => 'array',
        'customer' => 'array',
        'km_packages' => 'array',
        'insurance_packages' => 'array',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
