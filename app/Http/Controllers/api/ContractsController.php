<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContractCreated;
use App\Models\Company;
use App\Models\Setting;
use Carbon\Carbon;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Car;

class ContractsController extends Controller
{
    public function addContract(Request $request)
    {
        $apiToken = $request->header('Authorization');
        if (!$this->isValidApiToken($apiToken)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $validatedData = $request;
        if ($request->hasFile('identity_front')) {
            $identityFrontName = uniqid('identity_front_', true) . '.' . $request->file('identity_front')->getClientOriginalExtension();
        } else {
            return response()->json(['error' => 'Identity front file is missing'], 400);
        }
        
        if ($request->hasFile('identity_back')) {
            $identityBackName = uniqid('identity_back_', true) . '.' . $request->file('identity_back')->getClientOriginalExtension();
        } else {
            return response()->json(['error' => 'Identity back file is missing'], 400);
        }
        
        if ($request->hasFile('driving_front')) {
            $drivingFrontName = uniqid('driving_front_', true) . '.' . $request->file('driving_front')->getClientOriginalExtension();
        } else {
            return response()->json(['error' => 'Driving front file is missing'], 400);
        }
        
        if ($request->hasFile('driving_back')) {
            $drivingBackName = uniqid('driving_back_', true) . '.' . $request->file('driving_back')->getClientOriginalExtension();
        } else {
            return response()->json(['error' => 'Driving back file is missing'], 400);
        }
        
        // Dosya yollarını tanımlama
        $identityFrontPath = 'assets/images/identity/' . $identityFrontName;
        $identityBackPath = 'assets/images/identity/' . $identityBackName;
        $drivingFrontPath = 'assets/images/licence/' . $drivingFrontName;
        $drivingBackPath = 'assets/images/licence/' . $drivingBackName;
        
        // Dosya dizinlerini kontrol et ve oluştur
        $identityPath = public_path('assets/images/identity');
        $drivingPath = public_path('assets/images/licence');
        
        if (!file_exists($identityPath)) {
            mkdir($identityPath, 0777, true);
        }
        
        if (!file_exists($drivingPath)) {
            mkdir($drivingPath, 0777, true);
        }
        
        // Dosyaları taşıma
        if ($request->file('identity_front')->isValid() && $request->file('identity_back')->isValid() &&
        $request->file('driving_front')->isValid() && $request->file('driving_back')->isValid()) {
            
            $request->file('identity_front')->move($identityPath, $identityFrontName);
            $request->file('identity_back')->move($identityPath, $identityBackName);
            $request->file('driving_front')->move($drivingPath, $drivingFrontName);
            $request->file('driving_back')->move($drivingPath, $drivingBackName);
        } else {
            return response()->json(['error' => 'Some files are not valid.'], 422);
        }
        if ($validatedData['payment_method'] == 'online') {
            $customerDataJson = json_decode($validatedData['customer_details'], true);
            $customer = Customer::create([
                'company_name' => 'Web Api',
                'company_id' => $validatedData['company_id'],
                'name' => $customerDataJson['name'],
                'surname' => $customerDataJson['surname'],
                'status' => 2,
                'address' => json_encode([
                    'country' => $customerDataJson['country'],
                    'city' => $customerDataJson['city'],
                    'street' => $customerDataJson['street'],
                    'zip_code' => $customerDataJson['zip_code'],
                ]),
                'invoice_info' => json_encode([
                    'company_name' => 'Web Api',
                    'name' => $customerDataJson['name'],
                    'surname' => $customerDataJson['surname'],
                    'country' => $customerDataJson['country'],
                    'city' => $customerDataJson['city'],
                    'street' => $customerDataJson['street'],
                    'zip_code' => $customerDataJson['zip_code'],   
                ]),
                'invoice_status' => 1,
                'phone' => $customerDataJson['phone'],
                'email' => $customerDataJson['email'],
                'date_of_birth' => $customerDataJson['age'],
                'driving_licence' => json_encode([
                    'front' => $drivingFrontPath,
                    'back' => $drivingBackPath,
                    'expiry_date' => $customerDataJson['driving_expiry_date'],
                ]),
                'identity' => json_encode([
                    'front' => $identityFrontPath,
                    'back' => $identityBackPath,
                    'expiry_date' => $customerDataJson['identity_expiry_date'],
                ]),
            ]);
            
            $customer->save();
            $customerInfo = [
                'id' => $customer->id ?? '',
                'name' => $customer->name ?? '',
                'surname' => $customer->surname ?? '',
                'email' => $customer->email ?? '',
                'date_of_birth' => $customer->date_of_birth ?? '',
                'phone' => $customer->phone ?? '',
                'email' => $customer->email ?? '',
                'address' => $customer->address ?? '',
                'invoice_info' => $customer->invoice_info ?? '',
                'invoice_status' => $customer->invoice_status ?? '',
                'driving_licence' => $customer->driving_licence ?? '',
                'identity' => $customer->identity ?? '',
            ];
            $carDataJson = json_decode($validatedData['car_details'], true);
            $contractData = [
                'company_id' => $validatedData['company_id'],
                'car' => json_decode($validatedData['car_details'], true),
                'customer' => json_encode($customerInfo, true),
                'car_group' => $validatedData['car_group'],
                'car_id' => $validatedData['car_id'],
                'customer_id' => $customer->id,
                'km_packages' => $validatedData['km_packages'],
                'insurance_packages' => $validatedData['insurance_packages'],
                'discount' => "0",
                'payment_option' => $validatedData['payment_method'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'tax' => 19,
                'amount_paid' => $validatedData['amount_paid'],
                'remaining_paid' => $validatedData['remaining_amount'],
                'description' => "web",
                'total_amount' => $validatedData['totalprice'],
                'car_subtotal_price' => $validatedData['totalprice'],
                'deposit' => $validatedData['deposito'],
                'status' => 3,
                'fuel_status' => $validatedData['fuel_status'],
                'damages' => json_encode($carDataJson['damages'], true),
                'internal_damages' => json_encode($carDataJson['internal_damages'], true),
                'options' => json_encode($carDataJson['options'],true),
            ];
            
            session(['contract_data' => $contractData]);
            
            // Oturumdan veriyi kontrol et
            $sessionData = session('contract_data');
            return response()->json([
                'success' => true,
                'payment_method' => $validatedData['payment_method'], // Bu satır, payment_method değerini döndürür
                'contract_data' => session('contract_data'),
            ], 201);
        }else{
            $customerDataJson = json_decode($validatedData['customer_details'], true);
            $customer = Customer::create([
                'company_name' => 'Web Api',
                'company_id' => $validatedData['company_id'],
                'name' => $customerDataJson['name'],
                'surname' => $customerDataJson['surname'],
                'status' => 2,
                'address' => json_encode([
                    'country' => $customerDataJson['country'],
                    'city' => $customerDataJson['city'],
                    'street' => $customerDataJson['street'],
                    'zip_code' => $customerDataJson['zip_code'],
                ]),
                'invoice_info' => json_encode([
                    'company_name' => 'Web Api',
                    'name' => $customerDataJson['name'],
                    'surname' => $customerDataJson['surname'],
                    'country' => $customerDataJson['country'],
                    'city' => $customerDataJson['city'],
                    'street' => $customerDataJson['street'],
                    'zip_code' => $customerDataJson['zip_code'],   
                ]),
                'invoice_status' => 1,
                'phone' => $customerDataJson['phone'],
                'email' => $customerDataJson['email'],
                'date_of_birth' => $customerDataJson['age'],
                'driving_licence' => json_encode([
                    'front' => $drivingFrontPath,
                    'back' => $drivingBackPath,
                    'expiry_date' => $customerDataJson['driving_expiry_date'],
                ]),
                'identity' => json_encode([
                    'front' => $identityFrontPath,
                    'back' => $identityBackPath,
                    'expiry_date' => $customerDataJson['identity_expiry_date'],
                ]),
            ]);
            
            $customer->save();
            $customerInfo = [
                'id' => $customer->id ?? '',
                'name' => $customer->name ?? '',
                'surname' => $customer->surname ?? '',
                'email' => $customer->email ?? '',
                'date_of_birth' => $customer->date_of_birth ?? '',
                'phone' => $customer->phone ?? '',
                'email' => $customer->email ?? '',
                'address' => $customer->address ?? '',
                'invoice_info' => $customer->invoice_info ?? '',
                'invoice_status' => $customer->invoice_status ?? '',
                'driving_licence' => $customer->driving_licence ?? '',
                'identity' => $customer->identity ?? '',
            ];
            $carDataJson = json_decode($validatedData['car_details'], true);
            $contract = new Contract();
            $contract->company_id = $validatedData['company_id'];
            $contract->car = $validatedData['car_details'];
            $contract->customer = json_encode($customerInfo, true);
            $contract->car_group = $validatedData['car_group'];
            $contract->car_id = $validatedData['car'];
            $contract->customer_id = $customer->id; // not
            
            $contract->km_packages = $validatedData['km_packages'];
            $contract->insurance_packages = $validatedData['insurance_packages'];
            
            $contract->discount = '0'; // Varsayılan olarak 0
            $contract->payment_option = $validatedData['payment_method'];
            
            $contract->start_date = $validatedData['start_date'];
            $contract->end_date = $validatedData['end_date'];
            $contract->tax = 19;
            $contract->amount_paid = $validatedData['amount_paid'];
            $contract->remaining_paid = $validatedData['remaining_amount'];
            $contract->description = 'web';
            $contract->total_amount = $validatedData['totalprice'];
            $contract->car_subtotal_price = $validatedData['totalprice'];
            $contract->deposit = $validatedData['deposito'];
            $contract->status = 3; // Varsayılan olarak 3
            $contract->fuel_status = $carDataJson['fuel_status'];
            $contract->damages = json_encode($carDataJson['damages'], true);
            $contract->internal_damages = json_encode($carDataJson['internal_damages'], true);
            $contract->options = json_encode($carDataJson['options'],true);
            
            
            $contract->save();
            
            $customerEmail = $customerDataJson['email'];
            $customerName = $customerDataJson['name'].''. $customerDataJson['surname'];
            $company = Company::find(1);
            $companyName = $company->name;  // İlişki ile company bilgisi alınır
            
            $subject = $companyName . ' - Contract Add for ' . $customerName;
            $contractMailTemplate = Setting::where('key', 'contract_add_mail')->value('value');
            
            Mail::to($customerEmail)->send(new ContractCreated($contract, $subject, $contractMailTemplate));
            
            return response()->json(['success' => 'Contract created successfully!'], 201);
        }
        
    }
    
    // API token doğrulama fonksiyonu
    private function isValidApiToken($apiToken)
    {
        $validToken = '144qwe4qwe412';
        
        return $apiToken === 'Bearer ' . $validToken;
    }
    public function getCarsByGroup($groupId)
    {
        // Araçları grup id'sine göre çek
        $cars = Car::where('group_id', $groupId)->get();
        
        $carData = [];
        
        foreach ($cars as $car) {
            // Sözleşmeleri car_id'ye göre çek
            $contracts = Contract::where('car_id', $car->id)->get(['start_date', 'end_date']);
            
            // Müsaitlik durumu (örneğin, araç kiralanmış mı)
            $availability = $contracts->isEmpty() ? 'available' : 'unavailable';
            
            // Araç ve sözleşme bilgilerini dizi halinde ekle
            $carDetails = json_decode($car->car, true);
            $carPrices = json_decode($car->prices, true);
            $carData[] = [
                'id' => $car->id,
                'brand' => $carDetails['brand'], // JSON'dan marka bilgisi
                'model' => $carDetails['model'], // JSON'dan model bilgisi
                'number_plate' => $car->number_plate,
                'prices' => $carPrices, // prices JSON formatında olduğu için direkt döndürüyoruz
                'contracts' => $contracts, // Sözleşmeleri JSON formatında döndür
                'availability' => $availability, // Müsaitlik durumunu ekle
            ];
        }
        
        return response()->json($carData);
    }
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'car_id' => 'required|integer|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        
        $carId = $request->input('car_id');
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));
        
        // Araç bilgilerini al
        $car = Car::find($carId);
        
        if (!$car) {
            return response()->json(['message' => 'Araç bulunamadı'], 404);
        }
        
        // Araç için mevcut sözleşmeleri al
        $contracts = Contract::where('car_id', $carId)
        ->where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate])
            ->orWhereBetween('end_date', [$startDate, $endDate])
            ->orWhere(function ($query) use ($startDate, $endDate) {
                $query->where('start_date', '<=', $startDate)
                ->where('end_date', '>=', $endDate);
            });
        })
        ->get();
        
        // Müsaitlik durumu belirle
        $availability = $contracts->isEmpty() ? 'available' : 'unavailable';
        
        return response()->json([
            'car_id' => $carId,
            'availability' => $availability,
            'contracts' => $contracts,  // Sözleşmeleri de döndürüyoruz ki JavaScript'te gösterelim
        ]);
    }
}
