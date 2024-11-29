<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarGroup extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'prices',
        'kilometers',
        'km_packages',
        'insurance_packages',
        'company_id',
    ];
    
    protected $casts = [
        'prices' => 'array',
        'kilometers' => 'array',
        'km_packages' => 'array',
        'insurance_packages' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
