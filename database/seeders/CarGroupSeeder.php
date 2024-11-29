<?php

namespace Database\Seeders;

use App\Models\CarGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CarGroup::create([
            'name' => 'Economy',
            'prices' => json_encode([
                'daily_standard_price' => '10',
                'price_for_additional_driver' => '10',
                'daily_price' => '10',
                'deposito' => '22',
                'standard_exemption' => '22',
                'price_per_extra_kilometer' => '10'
            ]),
            'kilometers' => json_encode([
                'daily_free_km' => '10',
                'daily_standard_km' => '10',
                'daily_kilometer' => '10'
            ]),
            'company_id' => '1',
        ]);
    }
}
