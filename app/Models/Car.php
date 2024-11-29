<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'car',
        'company_id',
        'odometer',
        'vin',
        'car_group',
        'number_of_doors',
        'key_number',
        'tire_size',
        'rim_size',
        'tire_type',
        'fuel_status',
        'damages',
        'internal_damages',
        'number_plate',
        'date_to_traffic',
        'standard_exemption',
        'age',
        'status',
        'group_id',
        'prices',
        'kilometers',
        'km_packages',
        'insurance_packages',
        'images',
        'description',
        'horse_power',
        'fuel',
        'options',
        'color',
    ];
    
    protected $casts = [
        'car' => 'array',
        'prices' => 'array',
        'kilometers' => 'array',
        'km_packages' => 'array',
        'insurance_packages' => 'array',
        'images' => 'array',
        'damages' => 'array',
        'internal_damages' => 'array',
        'options' => 'array',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function carGroup()
    {
        return $this->belongsTo(CarGroup::class, 'group_id');
    }

    public function scopeAvailable($query, $date)
    {
        return $query->whereDoesntHave('contracts', function ($q) use ($date) {
            $q->where('start_date', '<=', $date)
              ->where('end_date', '>=', $date);
        });
    }
}
