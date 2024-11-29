<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'surname',
        'date_of_birth',
        'identity',
        'driving_licence',
        'company_id',
        'company_name',
        'email',
        'phone',
        'type',
        'address',
        'invoice_info',
        'invoice_status'
    ];
    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function contract()
    {
        return $this->hasMany(Contract::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
