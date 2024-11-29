<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'Safari GmbH',
            'tax_number' => '000000',
            'status' => '1',
            'address' => '{"country":"Türkiye","city":"Erzurum","street":"csk sokak","zip_code":"25488"}',
            'phone' => '+49 201 171 898 42',
            'fax' => '+49 201 890 934 81',
            'hrb' => '31854',
            'iban' => 'DE 58 3605 0105 0002 0591 29',
            'bic' => 'SPESDE3EXXX',
            'stnr' => '111/5726/2283',
            'ust_id_nr' => 'DE338067421',
            'registry_court' => 'Essen',
            'general_manager' => 'Sehmus Öztep, Abed Öztep',
            'reference_token' => Str::uuid()->toString(),  // Benzersiz referans token oluşturma
            'email' => 'info@oeztep-transporte.de'
        ]);
    }
}
