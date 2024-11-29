<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        
        $admin = User::create([
            'name' => 'Tarık',
            'surname' => 'Önal',
            'status' => '1',
            'address' => '{"country":"null","city":"null","street":"null","zip_code":"null"}',
            'phone' => '05350195525',
            'email' => 'safari@gmail.com',
            'password' => Hash::make('1234789')
        ]);
        $cAdmin1 = User::create([
            'name' => 'Max',
            'surname' => 'Musterman',
            'status' => '1',
            'company_id' => '1',
            'address' => '{"country":"null","city":"null","street":"null","zip_code":"null"}',
            'phone' => '000000000',
            'email' => 'info@jet-cars.de',
            'password' => Hash::make('123456789')
        ]);
        // Rolleri oluşturun
        $superAdminRole = Role::create(['guard_name' => 'superadmin','name' => 'Süper Admin']);
        $adminRole = Role::create(['name' => 'Firmenleiter']);
        
        Role::create(['name' => 'Mitarbeiter']);
        
        $admin->assignRole($superAdminRole);
        $cAdmin1->assignRole($adminRole);
        // Rollere izinleri atayın // Yeni izin, 'Firmenleiter' rolüne atanıyor
    }
}
