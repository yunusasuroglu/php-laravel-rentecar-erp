<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'profile_image',
        'logo',
        'email',
        'phone',
        'fax',
        'hrb',
        'iban',
        'bic',
        'stnr',
        'ust_id_nr',
        'registry_court',
        'general_manager',
        'reference_token',
        'status',
        'address',
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function cars()
    {
        return $this->hasMany(Car::class);
    }
    public function contract()
    {
        return $this->hasMany(Contract::class);
    }
    public function carGroups()
    {
        return $this->hasMany(CarGroup::class);
    }
    public function punishments()
    {
        return $this->hasMany(Punishment::class);
    }
}
