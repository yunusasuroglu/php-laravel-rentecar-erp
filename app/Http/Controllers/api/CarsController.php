<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Car;
use App\Models\Contract;
use Illuminate\Support\Facades\Auth;

class CarsController extends Controller
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
                        'car' => $car->car,
                        'class' => $car->class,
                        'company_id' => $car->company_id,
                        'odometer' => $car->odometer,
                        'vin' => $car->vin,
                        'car_group' => $car->car_group,
                        'number_of_doors' => $car->number_of_doors,
                        'key_number' => $car->key_number,
                        'tire_size' => $car->tire_size,
                        'rim_size' => $car->rim_size,
                        'tire_type' => $car->tire_type,
                        'fuel_status' => $car->fuel_status,
                        'damages' => $car->damages,
                        'internal_damages' => $car->internal_damages,
                        'number_plate' => $car->number_plate,
                        'date_to_traffic' => $car->date_to_traffic,
                        'standard_exemption' => $car->standard_exemption,
                        'age' => $car->age,
                        'status' => $car->status,
                        'group_id' => $car->group_id,
                        'prices' => $car->prices,
                        'kilometers' => $car->kilometers,
                        'km_packages' => $car->km_packages,
                        'insurance_packages' => $car->insurance_packages,
                        'images' => $car->images,
                        'description' => $car->description,
                        'horse_power' => $car->horse_power,
                        'fuel' => $car->fuel,
                        'options' => $car->options,
                        'color' => $car->color,
                    ];
                })->toArray(),
            ];
        }
        
        return response()->json($result);
    }
    public function getCarGroupsByCompany()
    {
        // Şirketlere göre gruplanmış araç grupları
        $companies = Company::with('carGroups')->get();
        
        // Şirket ID'sine göre gruplandırılmış bir array yapısı
        $result = [];
        
        foreach ($companies as $company) {
            $result[$company->id] = [
                'company_name' => $company->name,
                'car_groups' => $company->carGroups->map(function ($carGroup) {
                    return [
                        'id' => $carGroup->id,
                        'name' => $carGroup->name,
                        'company_id' => $carGroup->company_id,
                        'prices' => $carGroup->prices,
                        'kilometers' => $carGroup->kilometers,
                        'km_packages' => $carGroup->km_packages,
                        'insurance_packages' => $carGroup->insurance_packages,
                    ];
                })->toArray(),
            ];
        }
        
        return response()->json($result);
    }
    public function getCarAvailability($carId)
    {
        // Araç bilgilerini car_id'ye göre çek
        $car = Car::find($carId);
        
        // Eğer araç bulunamazsa, hata mesajı döndür
        if (!$car) {
            return response()->json(['message' => 'Car not found'], 404);
        }
        
        // Sözleşmeleri car_id'ye göre çek
        $contracts = Contract::where('car_id', $car->id)->get(['start_date', 'end_date']);
        
        // Müsaitlik durumu (örneğin, araç kiralanmış mı)
        $availability = $contracts->isEmpty() ? 'available' : 'unavailable';
    
        // Dönüş yapılacak veri
        $carData = [
            'id' => $car->id,
            'contracts' => $contracts,
            'availability' => $availability,
        ];
    
        // JSON formatında cevap döndür
        return response()->json($carData);
    }
}
