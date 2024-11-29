<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'car_id',
        'customer_id',
        'company_id',
        'car_group',
        'car',
        'customer',
        'start_date',
        'end_date',
        'km_packages',
        'insurance_packages',
        'discount',
        'amount_paid',
        'remaining_paid',
        'total_amount',
        'deposit',
        'payment_option',
        'description',
        'signature',
        'user_signature',
        'status',
        'extra_km',
        'extra_km_price',
        'extra_date',
        'pickup_date',
        'damages',
        'internal_damages',
        'fuel_status',
        'options',
        'deliver_damages_image',
        'pickup_damages_image',
    ];

    protected $casts = [
        'car' => 'array',
        'customer' => 'array',
        'km_packages' => 'array',
        'insurance_packages' => 'array',
        'damages' => 'array',
        'internal_damages' => 'array',
        'options' => 'array',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
