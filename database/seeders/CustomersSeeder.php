<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Customer::create([
        //     'name' => 'John',
        //     'surname' => 'Doe',
        //     'company_name' => 'John',
        //     'status' => '1',
        //     'company_id' => '1',
        //     'address' => '{"country":"Türkiye","city":"Erzurum","street":"csk sokak","zip_code":"25488"}',
        //     'invoice_address' => '{"country":"Türkiye","city":"Erzurum","street":"csk sokak","zip_code":"25488"}',
        //     'phone' => '+49 201 171 898 42',
        //     'email' => 'info@oeztep-transporte.de',
        //     'date_of_birth' => '1990-01-01',
        //     'driving_licence' => 's',
        //     'identity' => 's',
        // ]);
    }
}
