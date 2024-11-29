<?php

namespace App\Http\Controllers\Company\Calender;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalenderController extends Controller
{
    public function Calender()
    {
        $user = auth()->user();
        $company = $user->company;
        
        $contracts = Contract::where('company_id', $company->id)->get();
        
        $today = \Carbon\Carbon::now()->startOfDay();
        
        $contractsData = $contracts->map(function ($contract) use ($today) {
            // Arabayla ilgili verileri JSON'dan çözümleyelim
            $carData = json_decode($contract->car, true)['car'] ?? [];
            $carData2 = json_decode($contract->car, true);
            
            // Marka, model ve plaka numarası bilgilerini alalım
            $brand = $carData['brand'] ?? 'Bilinmeyen Marka';
            $model = $carData['model'] ?? 'Bilinmeyen Model';
            $plateNumber = $carData2['number_plate'] ?? 'Bilinmeyen Plaka';
            
            // Sözleşme başlangıç ve bitiş tarihlerini Carbon ile işleyelim
            $startDate = \Carbon\Carbon::parse($contract->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($contract->end_date)->startOfDay();
            $updatedAt = \Carbon\Carbon::parse($contract->updated_at)->startOfDay(); // updated_at kontrolü için
            
            // Durum ve renk değişkenlerini tanımlayalım
            $status = null;
            $color = null;
            
            // Status kontrolü
            if ($contract->status == 3) {
                $status = 'Draft'; // Bugün eklenenler draft
                $color = 'grey'; // Gri renk
            } elseif ($contract->status == 5 && $updatedAt->isToday()) {
                $status = 'Pickup'; // Pickup olacak ve updated_at bugüne eşit olanlar
                $color = 'blue'; // Mavi renk
            } elseif ($startDate->isToday()  && $updatedAt->isToday()) {
                $status = 'Delivered'; // Teslim edilecek olanlar
                $color = 'green'; // Yeşil renk
            } elseif ($endDate->isToday()  && $updatedAt->isToday()) {
                $status = 'Received'; // Bitiş tarihi bugüne eşit olanlar
                $color = 'danger'; // Kırmızı renk
            } elseif ($startDate->isToday() && $endDate->isToday()) {
                $status = 'Delivered & Received'; // Hem teslim hem bitiş bugün olanlar
                $color = 'orange'; // Turuncu renk
            } else {
                return null; // Diğerlerini dahil etmiyoruz
            }
            
            // Veriyi geri döndürelim
            if (is_string($contract->customer)) {
                $customer = json_decode($contract->customer, true); // JSON string ise diziye çevir
            } else {
                // Zaten bir dizi ise, doğrudan kullan
                $customer = $contract->customer;
            }
            $customerName = $customer['name'] ?? 'not kunden';
            $customerSurname = $customer['surname'] ?? 'not kunden';
            $customerPhone = $customer['phone'] ?? 'not mobil';
            $customerEmail = $customer['email'] ?? 'not mobil';
            
            // Veriyi geri döndürelim
            return [
                'car' => $carData,
                'status' => $status,
                'start_date' => $contract->start_date,
                'end_date' => $contract->end_date,
                'color' => $color,
                'car_brand' => $brand,
                'car_model' => $model,
                'car_plate_number' => $plateNumber,
                'contract_id' => $contract->id, 
                'customer_name' => $customerName, 
                'customer_surname' => $customerSurname,
                'customer_phone' => $customerPhone,
                'customer_email' => $customerEmail,
            ];
        })->filter();
        
        $contracts2Data = $contracts->map(function ($contract) use ($today) {
            $carData = json_decode($contract->car, true)['car'] ?? [];
            $carData2 = json_decode($contract->car, true);
            
            $brand = $carData['brand'] ?? 'Bilinmeyen Marka';
            $model = $carData['model'] ?? 'Bilinmeyen Model';
            $plateNumber = $carData2['number_plate'] ?? 'Bilinmeyen Plaka';
            
            $startDate = \Carbon\Carbon::parse($contract->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($contract->end_date)->startOfDay();
            
            // Başlangıç tarihi bugünse yeşil, bitiş tarihi bugünse kırmızı
            if ($startDate->isToday()) {
                $color = 'green';
                $status = 'Delivered Today';  // Durumu isteğinize göre güncelleyebilirsiniz
            } elseif ($endDate->isToday()) {
                $color = 'red';
                $status = 'Received Today';  // Durumu isteğinize göre güncelleyebilirsiniz
            } else {
                return null;
            }
            // Veriyi geri döndürelim
            if (is_string($contract->customer)) {
                $customer = json_decode($contract->customer, true); // JSON string ise diziye çevir
            } else {
                // Zaten bir dizi ise, doğrudan kullan
                $customer = $contract->customer;
            }
            $customerName = $customer['name'] ?? 'not kunden';
            $customerSurname = $customer['surname'] ?? 'not kunden';
            $customerPhone = $customer['phone'] ?? 'not mobil';
            $customerEmail = $customer['email'] ?? 'not mobil';
            return [
                'car' => $carData,
                'status' => $status,
                'start_date' => $contract->start_date,
                'end_date' => $contract->end_date,
                'color' => $color,
                'car_brand' => $brand,
                'car_model' => $model,
                'car_plate_number' => $plateNumber,
                'contract_id' => $contract->id,
                'customer_name' => $customerName, 
                'customer_surname' => $customerSurname,
                'customer_phone' => $customerPhone,
                'customer_email' => $customerEmail,
                
            ];
        })->filter();
        return view('company.calender.calender',compact('contractsData','contracts2Data'));
    }
    public function CalenderEvents()
    {
        $companyId = auth()->user()->company_id;
        $activeContracts = Contract::where('company_id', $companyId)
        ->whereDate('start_date', '<=', now())
        ->whereDate('end_date', '>=', now())
        ->get();
        
        $resources = [];
        
        foreach ($activeContracts as $contract) {
            $carJsonString = $contract->car;
            
            $carArray = json_decode($carJsonString, true);
            
            if (is_array($carArray) && isset($carArray['car'])) {
                $carDetails = $carArray['car']; 
                
                $carTitle = $carDetails['brand'] . ' ' . $carDetails['model'] . ' (' . $carArray['number_plate'] . ')';
                $carGroup = $carArray['car_group'];
                
            } else {
                $carTitle = 'Unknown Car';
                $carGroup = 'Unknown Group';
            }
            if (!isset($resources[$carGroup])) {
                $resources[$carGroup] = [
                    "id" => $carGroup,
                    "title" => ucfirst($carGroup),
                    "children" => []
                ];
            }
            
            $resources[$carGroup]["children"][] = [
                "id" => $contract->car_id,
                "title" => $carTitle,
            ];
        }
        
        $resources = array_values($resources);
        $events = $activeContracts->map(function ($contract) {
            $today = Carbon::now();
            $startDate = Carbon::parse($contract->start_date);
            $endDate = Carbon::parse($contract->end_date);
            $color = 'green';
            
            if ($endDate->lt($today)) {
                $color = 'red';
            } elseif ($endDate->diffInDays($today) == 1) {
                $color = 'orange';
            } elseif ($startDate->diffInDays($endDate) == 7) {
                $color = 'grey';
            } elseif ($startDate->diffInDays($endDate) == 30) {
                $color = 'primary';
            }
            
            // Müşteri bilgilerini decode ediyoruz
            if (is_string($contract->customer)) {
                $customerArray = json_decode($contract->customer, true); // JSON string ise diziye çevir
            } else {
                // Zaten bir dizi ise, doğrudan kullan
                $customerArray = $contract->customer;
            }
            
            if (is_array($customerArray)) {
                $name = $customerArray['name'] ?? 'N/A';
                $surname = $customerArray['surname'] ?? 'N/A';
                $phone = $customerArray['phone'] ?? 'N/A';
                $email = $customerArray['email'] ?? 'N/A';
                $dateOfBirth = $customerArray['date_of_birth'] ?? null;
                $age = $dateOfBirth ? Carbon::parse($dateOfBirth)->diffInYears(Carbon::now()) : 'N/A';
            } else {
                $name = $surname = $phone = $email = $age = 'N/A';
            }
            
            return [
                'resourceId' => $contract->car_id,
                'title' => $contract->start_date . ' - ' . $contract->end_date,
                'start' => $contract->start_date,
                'end' => $contract->end_date,
                'url' => url('/contracts/detail/' . $contract->id),
                'color' => $color,
                'customer' => [
                    'name' => $name . ' ' . $surname,
                    'phone' => $phone,
                    'email' => $email,
                    'age' => $age
                    ]
                ];
            });
            
            return response()->json(['resources' => $resources, 'events' => $events]);
        }
    }
    