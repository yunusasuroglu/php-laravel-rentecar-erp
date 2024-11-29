<?php

namespace App\Http\Controllers\Company\Cars;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Company;
use App\Models\CarGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarsApiController extends Controller
{
    public function getCarsByCompany()
    {
        // Şirketlere göre gruplanmış araçlar
        $companies = Company::with('cars')->get();

        // Şirket ID'sine göre gruplandırılmış bir array yapısı
        $result = [];

        foreach ($companies as $company) {
            $result[$company->id] = [
                'company_name' => $company->name,
                'cars' => $company->cars->map(function ($car) {
                    return [
                        'id' => $car->id,
                        'name' => $car->name,
                        'model' => $car->model,
                        // Diğer gerekli araç bilgileri
                    ];
                })->toArray(),
            ];
        }

        return response()->json($result);
    }
}