<?php

namespace App\Http\Controllers\Company\Contracts;

use App\Http\Controllers\Controller;
use App\Mail\ContractCreated;
use App\Mail\ContractPickup;
use App\Mail\ContractDeliver;
use App\Mail\ContractResendMail;
use App\Models\Car;
use App\Models\CarGroup;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Setting;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContractsController extends Controller
{
    public function Contracts()
    {
        $companyId = auth()->user()->company_id;
        
        $contracts = Contract::where('company_id', $companyId)->orderBy('id', 'DESC')->get();
        return view('company.contracts.contracts', compact('contracts'));
    }
    public function ContractAdd()
    {
        $today = Carbon::today()->format('Y-m-d');
        $companyId = auth()->user()->company_id; // Kullanıcının şirket ID'sini al
        
        // Şirkete ait mevcut araçları al
        $available_cars = Car::where('company_id', $companyId)->available($today)->get();
        
        // Şirkete ait araç gruplarını al
        $car_groups = CarGroup::where('company_id', $companyId)->get();
        
        $customers = Customer::where('company_id', $companyId)->get();
        
        $contractData = session('contractData', []);
        if (!empty($contractData) && isset($contractData['car_details'])) {
            $carDetails = $contractData['car_details'];
            
            $kmPackages = $carDetails['km_packages'] ?? '[]';
            $insurancePackages = $carDetails['insurance_packages'] ?? '[]';
        } else {
            $carDetails = [];
            $kmPackages = [];
            $insurancePackages = [];
        }
        $carGroupId = $carDetails['group_id'] ?? null;
        $kmPackages = [];
        $insurancePackages = [];
        
        if ($carGroupId) {
            $carGroup = CarGroup::find($carGroupId);
            if ($carGroup) {
                // JSON sütunlarından kilometre ve sigorta paketlerini al
                $kmPackages = $carGroup->km_packages;
                $insurancePackages = $carGroup->insurance_packages;
            }
        }
        $carBrand = '';
        $carModel = '';
        $carColor = '';
        $carJson = '';
        $days = '1';
        $dailyPrice = '';
        $subTotalPrice = '0';
        $standardExemption = '0';
        $kmpack = [];
        $insurancepack = [];
        $deposito = '0';
        if (!empty($contractData)) {
            $carDetailsJson = $contractData['car_details']->car ?? '{}';
            $carDetails = $carDetailsJson;
            $carJson = $contractData['car_details'] ?? '';
            
            $carBrand = $carDetails['brand'] ?? '';
            $carModel = $carDetails['model'] ?? '';
            $carColor = $carJson['color'] ?? '';
            
            // Fiyat bilgilerini al
            $prices = $carJson['prices'] ?? '{}';
            $dailyPrice = $prices['daily_price'] ?? 0;
            $deposito = $prices['deposito'] ?? 0;
            
            // start_date ve end_date verilerini alıyoruz
            $startDate = isset($contractData['start_date']) ? new DateTime($contractData['start_date']) : null;
            $endDate = isset($contractData['end_date']) ? new DateTime($contractData['end_date']) : null;
            
            if ($startDate && $endDate) {
                // Tarihler arasındaki farkı hesaplıyoruz
                $dateInterval = $startDate->diff($endDate);
                $days = $dateInterval->days;
            }
            if ($days == 0) {
                $days = 1;
            }
            // Toplam fiyatı hesapla
            $subTotalPrice = $dailyPrice * $days;
        }
        $damagesArray = $carJson['damages'] ?? [];
        
        //dd($contractData);        
        return view('company.contracts.contract-add', compact('available_cars','carDetails','dailyPrice','carJson', 'kmpack','insurancepack','days', 'deposito', 'carColor', 'carBrand', 'carModel', 'car_groups', 'customers', 'contractData', 'insurancePackages', 'kmPackages','subTotalPrice'));
    }
    public function ContractStoreStep1(Request $request)
    {
        $companyId = Auth::user()->company_id;
        // Get the validated data
        $ValidateData = $request->validate([
            'car' => 'required|exists:cars,id',
            'car_group' => 'required',
            'customer' => 'required|string',
            'step' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'car.required' => 'The car field is required.',
            'car_group.required' => 'The car group field is required.',
            'car.exists' => 'The selected car is invalid.',
            'customer.required' => 'The customer field is required.',
            'step.required' => 'The step field is required.',
            'start_date.required' => 'The start date field is required.',
            'end_date.required' => 'The end date field is required.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
        ]);;
        
        // Retrieve car and customer details
        $car = Car::find($ValidateData['car']);
        
        // Add car details to the session
        $contractData['car_details'] = [
            'id' => $car->id,
            'car' => json_decode($car->car, true),
            'class' => $car->class,
            'daily_free_km' => $car->daily_free_km,
            'daily_kilometer' => $car->daily_kilometer,
            'horse_power' => $car->horse_power,
            'fuel' => $car->fuel,
            'color' => $car->color,
            'description' => $car->description,
            'age' => $car->age,
            'tire_type' => $car->tire_type,
            'tire_size' => $car->tire_size,
            'rim_size' => $car->rim_size,
            'key_number' => $car->key_number,
            'odometer' => $car->odometer,
            'vin' => $car->vin,
            'fuel_status' => $car->fuel_status,
            'car_group' => $car->car_group,
            'number_plate' => $car->number_plate,
            'date_to_traffic' => $car->date_to_traffic,
            'standard_exemption' => $car->standard_exemption,
            'prices' => json_decode($car->prices, true),
            'status' => $car->status,
            'km_packages' => json_decode($car->km_packages, true),
            'damages' => json_decode($car->damages, true),
            'internal_damages' => json_decode($car->internal_damages, true),
            'options' => $car->options,
            'insurance_packages' => json_decode($car->insurance_packages, true),
            'images' => json_decode($car->images, true),
            'company_id' => $car->company_id,
            'group_id' => $car->group_id,
            'created_at' => $car->created_at->toDateTimeString(),
            'updated_at' => $car->updated_at->toDateTimeString(),
        ];
        
        if ($ValidateData['customer'] == 'new_customer') {
            // Dosya yükleme işlemi ve dosya yolları
            $identityFrontPath = $this->moveUploadedFile($request->file('identity_front'), 'identity');
            $identityBackPath = $this->moveUploadedFile($request->file('identity_back'), 'identity');
            $driverLicenceFrontPath = $this->moveUploadedFile($request->file('driver_licence_front'), 'licence');
            $driverLicenceBackPath = $this->moveUploadedFile($request->file('driver_licence_back'), 'licence');
            
            // Invoice info ve status
            if ($request->input('invoice_address_active')) {
                $invoiceInfo = [
                    'company_name' => $request['invoice_company_name'],
                    'name' => $request['invoice_name'],
                    'surname' => $request['invoice_surname'],
                    'country' => $request['invoice_country'],
                    'city' => $request['invoice_city'],
                    'street' => $request['invoice_street'],
                    'zip_code' => $request['invoice_zip_code'],
                ];
                $status = 2;
            } else {
                $invoiceInfo = [
                    'company_name' => $request['company_name'],
                    'name' => $request['name'],
                    'surname' => $request['surname'],
                    'country' => $request['country'],
                    'city' => $request['city'],
                    'street' => $request['street'],
                    'zip_code' => $request['zip_code'],
                ];
                $status = 1;
            }
            
            // Customer modelini oluşturma ve kaydetme
            $customer = Customer::create([
                'company_name' => $request['company_name'],
                'company_id' => $companyId,
                'name' => $request['name'],
                'surname' => $request['surname'],
                'status' => 2, // Varsayılan olarak aktif durumu
                'address' => json_encode([
                    'country' => $request['country'],
                    'city' => $request['city'],
                    'street' => $request['street'],
                    'zip_code' => $request['zip_code'],
                ]),
                'invoice_info' => json_encode($invoiceInfo),
                'invoice_status' => $status,
                'phone' => $request['phone'],
                'email' => $request['email'],
                'date_of_birth' => $request['date_of_birth'],
                'driving_licence' => json_encode([
                    'front' => $driverLicenceFrontPath,
                    'back' => $driverLicenceBackPath,
                    'expiry_date' => $request['driver_licence_expiry_date'],
                ]),
                'identity' => json_encode([
                    'front' => $identityFrontPath,
                    'back' => $identityBackPath,
                    'expiry_date' => $request['identity_expiry_date'],
                ]),
            ]);
            
            $contractData['customer_details'] = [
                'id' => $customer->id,
                'name' => $customer->name,
                'surname' => $customer->surname,
                'date_of_birth' => $customer->date_of_birth,
                'identity' => json_decode($customer->identity, true),
                'driving_licence' => json_decode($customer->driving_licence, true),
                'company_name' => $customer->company_name,
                'phone' => $customer->phone,
                'email' => $customer->email,
                'address' => json_decode($customer->address, true), // JSON string'i array olarak döner
                'invoice_status' => $customer->invoice_status,
                'invoice_info' => json_decode($customer->invoice_info, true), // JSON string'i array olarak döner
                'status' => $customer->status,
                'created_at' => $customer->created_at->toDateTimeString(),
                'updated_at' => $customer->updated_at->toDateTimeString(),
            ];
            $contractData['customer'] = "$customer->id";
        } else {
            $customer = Customer::find($ValidateData['customer']);
            $contractData['customer_details'] = [
                'id' => $customer->id,
                'name' => $customer->name,
                'surname' => $customer->surname,
                'date_of_birth' => $customer->date_of_birth,
                'identity' => json_decode($customer->identity, true),
                'driving_licence' => json_decode($customer->driving_licence, true),
                'company_name' => $customer->company_name,
                'phone' => $customer->phone,
                'email' => $customer->email,
                'address' => json_decode($customer->address, true), // JSON string'i array olarak döner
                'invoice_status' => $customer->invoice_status,
                'invoice_info' => json_decode($customer->invoice_info, true), // JSON string'i array olarak döner
                'status' => $customer->status,
                'created_at' => $customer->created_at->toDateTimeString(),
                'updated_at' => $customer->updated_at->toDateTimeString(),
            ];
            $contractData['customer'] = "$customer->id";
        }
        $contractData['step'] = $request['step'];
        $contractData['start_date'] = $ValidateData['start_date'];
        $contractData['end_date'] = $ValidateData['end_date'];
        $contractData['car_group'] = $ValidateData['car_group'];
        $contractData['car'] = $ValidateData['car'];
        $contractData['totalprice'] = $request['totalPrice'];
        $contractData['subtotalprice'] = $request['subTotalPrice'];
        $contractData['tax'] = $request['tax'];
        $contractData['deposito'] = $request['deposito'];
        $contractData['standard_exemption'] = $request['standard_exemption'];
        session(['contractData' => $contractData]);
        return redirect()->route('contracts.add');
    }
    public function ContractStoreBackStep1(Request $request)
    {
        $validatedData = $request;
        
        $contractData = session('contractData', []);
        $step = $validatedData['step'];
        
        $contractData['step'] = $step;
        session(['contractData' => $contractData]);
        
        return redirect()->route('contracts.add');
    }
    public function ContractStoreStep2(Request $request)
    {
        // Form verilerini doğrula
        $validatedData = $request;
        
        // Session'dan önceki verileri al
        $contractData = session('contractData', []);
        
        // Kilometre ve sigorta paketlerini JSON formatında al
        $kmPackage = $validatedData['selected_km_package'];
        $kmPackageEnter = $validatedData['km_packages_group'];
        $insurancePackage = json_decode($validatedData['selected_insurance_package'], true);
        $step = $validatedData['step'];
        
        if ($kmPackageEnter === 'enter_yourself') {
            $kmPackage = [
                'kilometers' => $validatedData['kilometers_kilometer'],
                'extra_price' => $validatedData['kilometers_extra_price']
            ];
        } else {
            // JSON olarak decode edin
            $kmPackage = json_decode($kmPackage, true);
        }
        // Step 2 verilerini session'a ekle
        $contractData['km_packages'] = $kmPackage;
        $contractData['insurance_packages'] = $insurancePackage;
        $contractData['step'] = $step;
        $contractData['totalprice'] = $validatedData['totalprice'];
        $contractData['tax'] = $validatedData['tax'];
        
        // Güncellenmiş veriyi session'a kaydet
        session(['contractData' => $contractData]);
        // Success mesajı ekle ve aynı sayfaya yönlendir
        return redirect()->route('contracts.add');
    }
    public function ContractStoreBackStep2(Request $request)
    {
        $validatedData = $request;
        
        $contractData = session('contractData', []);
        $step = $validatedData['step'];
        
        $contractData['step'] = $step;
        session(['contractData' => $contractData]);
        
        return redirect()->route('contracts.add');
    }
    public function ContractStoreStep3(Request $request)
    {
        // Form verilerini doğrula
        $validatedData = $request;
        
        // Session'dan önceki verileri al
        $contractData = session('contractData', []);
        
        // Ödeme detaylarını al
        // Ödeme detaylarını al
        $paymentMethod = $validatedData['payment']; // 'Cash' veya 'Credit/Debit Card'
        $amountPaid = (float)($validatedData['amount_paid'] ?? 0);
        $step = $validatedData['step'];
        $totalPrice = (float)($contractData['totalprice'] ?? 0);
        $previousAmountPaid = (float)($contractData['amount_paid'] ?? 0);
        $deposit = (float)($contractData['deposito'] ?? 0);
        
        // Önceki ödemeleri hesaba katın ve toplam ödemenin üzerine yeni ödemeyi ekleyin
        $newAmountPaid = $previousAmountPaid + $amountPaid;
        $remainingAmount = $totalPrice - $newAmountPaid;
        
        if ($remainingAmount <= 0) {
            $contractData['payment_method'] = $paymentMethod;
            $contractData['amount_paid'] = $totalPrice;
            $contractData['deposito'] = $deposit;
            $contractData['step'] = $step;
            $contractData['totalprice'] = $totalPrice;
            $contractData['remaining_amount'] = 0;
        } else {
            // Step 3 verilerini session'a ekle
            $contractData['payment_method'] = $paymentMethod;
            $contractData['amount_paid'] = $newAmountPaid;
            $contractData['deposito'] = $deposit;
            $contractData['step'] = $step;
            $contractData['totalprice'] = $totalPrice;
            $contractData['remaining_amount'] = $remainingAmount;
        }
        
        
        session(['contractData' => $contractData]);
        // Success mesajı ekle ve onay sayfasına yönlendir
        return redirect()->route('contracts.add');
    }
    public function ContractStoreBackStep3(Request $request)
    {
        $validatedData = $request;
        
        $contractData = session('contractData', []);
        $step = $validatedData['step'];
        
        $contractData['step'] = $step;
        session(['contractData' => $contractData]);
        return redirect()->route('contracts.add');
    }
    public function ContractStoreStep4(Request $request)
    {
        $companyId = auth()->user()->company_id;
        // Form verilerini doğrula
        $validatedData = $request;
        
        // Session'dan önceki verileri al
        $contractData = session('contractData', []);
        
        // Ödeme detaylarını al
        $step = $validatedData['step'];
        // Step 3 verilerini session'a ekle
        $contractData['step'] = $step;
        $contractData = $request->session()->get('contractData');
        $cardetail = $contractData['car_details'];
        // Contract modelini kullanarak veritabanına kaydedin
        $contract = new Contract();
        $contract->company_id = $companyId;
        $contract->car = json_encode($contractData['car_details']);
        $contract->customer = json_encode($contractData['customer_details']);
        $contract->car_group = $contractData['car_group'];
        $contract->car_id = $contractData['car'];
        $contract->customer_id = $contractData['customer'];
        $contract->km_packages = json_encode($contractData['km_packages']);
        $contract->insurance_packages = json_encode($contractData['insurance_packages']);
        $contract->discount = '0';
        $contract->payment_option = $contractData['payment_method'];
        $contract->description = $contractData['start_date'];
        $contract->tax = $contractData['tax'];
        $contract->status = 3;
        $contract->fuel_status = $cardetail['fuel_status'];
        $contract->start_date = $contractData['start_date'];
        $contract->end_date = $contractData['end_date'];
        $contract->damages = json_encode($cardetail['damages']);
        $contract->internal_damages = json_encode($cardetail['internal_damages']);
        $contract->amount_paid = $contractData['amount_paid'];
        $contract->remaining_paid = $contractData['remaining_amount'];
        $contract->total_amount = $contractData['totalprice'];
        $contract->car_subtotal_price = $contractData['subtotalprice'];
        $contract->deposit = $contractData['deposito'];
        
        $customerData = $contractData['customer_details'];
        $contract->save();
        
        
        $customerEmail = $customerData['email'];
        $customerName = $customerData['name'].''. $customerData['surname'];
        $companyName = auth()->user()->company->name;  // İlişki ile company bilgisi alınır
        
        $subject = $companyName . ' - Contract Details for ' . $customerName;
        
        $contractMailTemplate = Setting::where('key', 'contract_add_mail')->value('value');
        
        Mail::to($customerEmail)->send(new ContractCreated($contract, $subject, $contractMailTemplate));
        $request->session()->forget('contractData');
        
        return redirect()->route('contracts');
    }
    private function moveUploadedFile($file, $type)
    {
        if ($file) {
            // Benzersiz bir dosya adı oluşturun
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Dosyayı belirtilen dizine kaydedin
            $filePath = $file->storeAs('public/' . $type, $fileName);
            
            return $filePath;
        }
        return null;
    }
    
    
    public function ContractDeliver($id)
    {
        // Contract verilerini veritabanından alın
        $contract = Contract::findOrFail($id);
        $customerId = $contract->customer_id;
        $customer = Customer::findOrFail($customerId);
        // Car verilerini alın ve JSON'dan dizilere çevirin
        $carDetailsJson = $contract->car;
        $carDetails = json_decode($carDetailsJson, true);
        
        $carId = $carDetails['id'];
        $car = Car::findOrFail($carId);
        $carDamages = $carDetails['damages'];
        $carInternalDamages = $carDetails['internal_damages'] ?? '[""]';
        $options = is_string($carDetails['options']) ? json_decode($carDetails['options'], true) : $carDetails['options'];;
        
        $kmPackagesJson = json_decode($contract->km_packages, true);
        $insurancePackagesJson = json_decode($contract->insurance_packages, true);
        
        $carBrand = $carDetails['car']['brand'] ?? '';
        $carModel = $carDetails['car']['model'] ?? '';
        $carColor = $carDetails['number_plate'] ?? '';
        $deposito = $carDetails['prices']['deposito'] ?? '0';
        $standardExemption = $carDetails['prices']['standard_exemption'] ?? '0';
        $damagesArray = $carDamages;
        $internalDamagesArray = $carInternalDamages;
        
        // Tarih aralığını hesaplayın
        $startDate = new \DateTime($contract->start_date);
        $endDate = new \DateTime($contract->end_date);
        $dateInterval = $startDate->diff($endDate);
        $days = $dateInterval->days;
        
        // Toplam fiyatı hesaplayın
        $dailyPrice = $carDetails['prices']['daily_price'] ?? 0;
        $subTotalPrice = $dailyPrice * $days;
        $contractData = session('contractData', []);
        if($contract->status == 1){
            return redirect()->route('contracts.pickup',$contract->id);
        }elseif($contract->status == 5){
            return redirect()->route('contracts.invoice',$contract->id);
        }elseif($contract->status == 3){
            return view('company.contracts.contract-deliver', compact('carBrand', 'internalDamagesArray', 'standardExemption', 'customer', 'contractData', 'contract', 'carDetails', 'carModel', 'carColor', 'days', 'subTotalPrice', 'kmPackagesJson','options', 'insurancePackagesJson', 'deposito', 'damagesArray'));
        }
    }
    public function ContractDeliverStoreStep1(Request $request)
    {
        // Formdan gelen verileri doğrula
        $validatedData = $request->validate([
            'step' => 'required|string',
            'contract_id' => 'required|integer',
        ]);
        
        $step = $validatedData['step'];
        $contractId = $validatedData['contract_id'];
        
        // Tüm sözleşme verilerini oturumdan al
        $contractData = session('contractData', []);
        
        // Sözleşme ID'sine göre verileri sakla
        $contractData[$contractId] = $contractData[$contractId] ?? []; // Eğer sözleşme verisi yoksa, boş bir dizi oluştur
        
        // Gelen adımı sözleşme verilerine ekle
        $contractData[$contractId]['step'] = $step;
        
        // Güncellenmiş veriyi oturuma kaydet
        session(['contractData' => $contractData]);
        // Başarılı mesajı ile geri yönlendir
        return redirect()->back();
    }
    public function ContractDeliverStoreStep2(Request $request)
    {
        $validatedData = $request;
        $request->validate([
            'odometer' => 'required',
            'options' => 'required|array', // Options dizisinin mevcut olmasını sağla
            'options.*' => 'required|string', // Options dizisindeki her bir öğenin mevcut ve string olmasını sağla
        ]);
        $selectedOptions = json_encode($request->input('options'), JSON_UNESCAPED_UNICODE);
        
        
        // İç hasarları JSON formatında kaydet        
        $existingDamages = [];
        $index = 1;
        
        while ($request->has("old_description_$index")) {
            $existingDamages[] = [
                'coordinates' => [
                    'x' => $request->input("old_x_cordinate_$index"),
                    'y' => $request->input("old_y_cordinate_$index")
                ],
                'description' => $request->input("old_description_$index"),
                'photo' => $request->input("old_image_$index")
            ];
            $index++;
        }
        
        $newDamages = [];
        $index = 1;
        
        while ($request->has("damage-description-$index")) {
            $description = $request->input("damage-description-$index");
            $xCoordinate = $request->input("x-coordinate-$index");
            $yCoordinate = $request->input("y-coordinate-$index");
            $photo = $request->file("damage-photo-$index");
            
            $photoPath = null;
            if ($photo) {
                
                $extension = $photo->getClientOriginalExtension(); // Örneğin, jpg, png, vb.
                
                // Benzersiz dosya adı oluştur
                $fileName = uniqid() . '.' . $extension; 
                $photo->move(public_path('assets/images/damages/'), $fileName); 
                $photoPath = 'assets/images/damages/' . $fileName;
            }
            
            // Yeni hasar bilgilerini dizine ekle
            $newDamages[] = [
                'coordinates' => ['x' => $xCoordinate, 'y' => $yCoordinate],
                'description' => $description,
                'photo' => $photoPath,
            ];
            
            $index++;
        }
        
        $contractId = $validatedData['contract_id'];
        $carId = $validatedData['car_id'];
        $contractData[$contractId] = $contractData[$contractId] ?? [];
        
        $allDamages = array_merge($existingDamages, $newDamages);
        $car = Car::find($carId);
        $internalDamages = [];
        
        // Formdaki tüm iç hasar verilerini işleyelim
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'internal_damage_description_') !== false) {
                $damageIndex = str_replace('internal_damage_description_', '', $key);
                $description = $request->input('internal_damage_description_' . $damageIndex);
                
                if ($request->hasFile('internal_damage_image_' . $damageIndex)) {
                    $file = $request->file('internal_damage_image_' . $damageIndex);
                    
                    $extension = $file->getClientOriginalExtension(); // Örneğin, jpg, png, vb.
                
                    // Benzersiz dosya adı oluştur
                    $fileName = uniqid() . '.' . $extension; 
                    $file->move(public_path('assets/images/internal_damages/'), $fileName);
                    
                    $internalDamages[] = [
                        'description' => $description,
                        'image' => 'assets/images/internal_damages/' . $fileName,  
                    ];
                }
            }
        }
        // Mevcut iç hasarlar varsa, yenileriyle birleştir
        $existingInternalDamages = json_decode($car->internal_damages, true) ?? [];
        $mergedInternalDamages = array_merge($existingInternalDamages, $internalDamages);
        
        if ($car) {
            
            $car->damages = json_encode($allDamages);
            $car->internal_damages = json_encode($mergedInternalDamages);
            
            $car->fuel_status = $validatedData['fuel_status'];
            $car->save();
        } else {
            return redirect()->back()->withErrors(['car' => 'Araç bulunamadı.']);
        }
        $contract = Contract::find($contractId);
        if ($contract) {
            // 'car' sütunundaki JSON verisini diziye dönüştür
            $contractCarSelected = json_decode($contract->car, true); // true ekleyerek diziyi associative yapıyoruz
            $contractCarSelected['options'] = $selectedOptions;
            $contractCarSelected['damages'] = $allDamages;
            $contractCarSelected['internal_damages'] = $mergedInternalDamages;
            
            $contract->car = json_encode($contractCarSelected, JSON_UNESCAPED_UNICODE);
            
            $contract->fuel_status = $validatedData['fuel_status'];
            $contract->damages = json_encode($allDamages);
            $contract->internal_damages = json_encode($mergedInternalDamages);
            $contract->save();
        } else {
            return redirect()->back()->withErrors(['contract' => 'Not Found.']);
        }
        
        $base64Image = $request->input('damage_image');
        
        if ($base64Image) {
            if (strpos($base64Image, 'data:image/png;base64,') === 0) {
                list($type, $data) = explode(',', $base64Image, 2);
                
                $imageData = base64_decode($data);
                
                if ($imageData === false) {
                    return redirect()->back()->with('error', 'Base64 verisi decode edilemedi.');
                }
                
                $fileName = 'damage_image_' . time() . '.png';
                
                $filePath = 'assets/images/damages/canvas/' . $fileName;
                
                // Public dizin altındaki dosya yolunu oluştur
                $fullPath = public_path($filePath);
                
                
                $saved = file_put_contents($filePath, $imageData);
                
                $contractData[$contractId]['damage_deliver_image'] = $filePath;
            } else {
                return redirect()->back()->with('error', 'Geçersiz Öğe.');
            }
        }
        
        $contractData[$contractId]['fuel_status'] = $validatedData['fuel_status'];
        $contractData[$contractId]['step'] = $validatedData['step'];
        $contractData[$contractId]['odometer'] = $validatedData['odometer'];
        $contractData[$contractId]['options'] = $selectedOptions;
        $contractData[$contractId]['damages'] = $allDamages;
        $contractData[$contractId]['internal_damages'] = $mergedInternalDamages;
        session(['contractData' => $contractData]);
        
        return redirect()->back();
    }
    public function ContractDeliverStoreStep3(Request $request)
    {
        $contractId = $request->input('contract_id');
        $contract = Contract::findOrFail($contractId);
        if (is_string($contract->customer)) {
            $customerDetails = json_decode($contract->customer, true); // JSON string ise diziye çevir
        } else {
            // Zaten bir dizi ise, doğrudan kullan
            $customerDetails = $contract->customer;
        }
        $customerId = $contract->customer_id;
        $customer = Customer::findOrFail($customerId);
        
        $drivingLicence = $customerDetails['driving_licence'];
        if (is_string($drivingLicence)) {
            $drivingLicence = json_decode($customerDetails['driving_licence'],true); // JSON string ise diziye çevir
        } else {
            $drivingLicence = $customerDetails['driving_licence'];
        }

        $identity = $customerDetails['identity'];
        if (is_string($identity)) {
            $identity = json_decode($customerDetails['identity'],true); // JSON string ise diziye çevir
        } else {
            $identity = $customerDetails['identity'];
        }
        // Benzersiz isimler ve yollar için başlangıç değerleri
        $identityFrontPath = $identity['front'] ?? '';
        $identityBackPath = $identity['back'] ?? '';
        $driverLicenceFrontPath = $drivingLicence['front'] ?? '';
        $driverLicenceBackPath = $drivingLicence['back'] ?? '';
        
        // Dosya yükleme ve yol ayarlama
        if ($request->hasFile('identity_front')) {
            $identityFrontName = uniqid() . '.' . $request->file('identity_front')->getClientOriginalExtension();
            $identityFrontPath = 'assets/images/identity/' . $identityFrontName;
            $request->file('identity_front')->move(public_path('assets/images/identity'), $identityFrontName);
        }
        
        if ($request->hasFile('identity_back')) {
            $identityBackName = uniqid() . '.' . $request->file('identity_back')->getClientOriginalExtension();
            $identityBackPath = 'assets/images/identity/' . $identityBackName;
            $request->file('identity_back')->move(public_path('assets/images/identity'), $identityBackName);
        }
        
        if ($request->hasFile('driver_licence_front')) {
            $driverLicenceFrontName = uniqid() . '.' . $request->file('driver_licence_front')->getClientOriginalExtension();
            $driverLicenceFrontPath = 'assets/images/licence/' . $driverLicenceFrontName;
            $request->file('driver_licence_front')->move(public_path('assets/images/licence'), $driverLicenceFrontName);
        }
        
        if ($request->hasFile('driver_licence_back')) {
            $driverLicenceBackName = uniqid() . '.' . $request->file('driver_licence_back')->getClientOriginalExtension();
            $driverLicenceBackPath = 'assets/images/licence/' . $driverLicenceBackName;
            $request->file('driver_licence_back')->move(public_path('assets/images/licence'), $driverLicenceBackName);
        }
        
        // Müşteri bilgilerini güncelle
        $customer->update([
            'identity' => json_encode([
                'front' => $identityFrontPath,
                'back' => $identityBackPath,
                'expiry_date' => $request->input('identity_expiry_date', $identity['expiry_date'] ?? '00-00-0000'),
            ]),
            'driving_licence' => json_encode([
                'front' => $driverLicenceFrontPath,
                'back' => $driverLicenceBackPath,
                'expiry_date' => $request->input('driver_licence_expiry_date', $drivingLicence['expiry_date'] ?? '00-00-0000'),
            ]),
        ]);
        
        // Sözleşme bilgilerini güncelle
        $contract->update([
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'surname' => $customer->surname,
                'date_of_birth' => $customer->date_of_birth,
                'company_name' => $customer->company_name,
                'phone' => $customer->phone,
                'email' => $customer->email,
                'address' => $customer->address,
                'invoice_status' => $customer->invoice_status,
                'invoice_info' => $customer->invoice_info,
                'status' => $customer->status,
                'identity' => [
                    'front' => $identityFrontPath,
                    'back' => $identityBackPath,
                    'expiry_date' => $request->input('identity_expiry_date', $identity['expiry_date'] ?? '00-00-0000'),
                ],
                'driving_licence' => [
                    'front' => $driverLicenceFrontPath,
                    'back' => $driverLicenceBackPath,
                    'expiry_date' => $request->input('driver_licence_expiry_date', $drivingLicence['expiry_date'] ?? '00-00-0000'),
                ],
                'created_at' => $customer->created_at,
                'updated_at' => $customer->updated_at,
            ]
        ]);
        
        
        $contractData = session('contractData', []);
        
        $contractData[$contractId] = $contractData[$contractId] ?? [];
        $contractData[$contractId]['step'] = $request->input('step');
        
        session(['contractData' => $contractData]);
        
        // Başarı mesajı ekle ve onay sayfasına yönlendir
        return redirect()->back();
    }
    public function ContractDeliverStoreStep4(Request $request)
    {
        $contractData = session('contractData', []);
        $companyId = auth()->user()->company_id;
        $userSignature = auth()->user()->signature;
        
        $signatureData = $request->input('signature');
        $contractId = $request->input('contract_id');
        
        $imageData = explode(',', $signatureData)[1];
        $imageData = base64_decode($imageData);
        
        
        $fileName = 'signature_' . time() . '.png';
        $directory = public_path('assets/images/signatures');
        
        
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        $filePath = $directory . '/' . $fileName;
        $imgurl = 'assets/images/signatures/' . $fileName;
        
        file_put_contents($filePath, $imageData);
        
        $contract = Contract::find($contractId);
        $contract->status = 1;
        $contract->options = $contractData[$contractId]['options'];
        $contract->signature = $imgurl;
        $contract->user_signature = $userSignature;
        $contract->deliver_damages_image = $contractData[$contractId]['damage_deliver_image'];
        
        $carDetailJson = json_decode($contract->car, true);
        $carDetailJson['odometer'] = $contractData[$contractId]['odometer'];
        $contract->car = json_encode($carDetailJson);
        $contract->save();
        
        $carId = $contract->car_id;
        $car = Car::find($carId);
        $car->odometer = $contractData[$contractId]['odometer'];
        $car->save();
        if (is_string($contract->customer)) {
            $customerData = json_decode($contract->customer, true); // JSON string ise diziye çevir
        } else {
            // Zaten bir dizi ise, doğrudan kullan
            $customerData = $contract->customer;
        }
        
        // Email'i alma
        $customerEmail = $customerData['email'];
        $customerName = $customerData['name'].''. $customerData['surname'];
        $companyName = auth()->user()->company->name;  // İlişki ile company bilgisi alınır
        
        $subject = $companyName . ' - Contract Handover for ' . $customerName;
        $contractMailTemplate = Setting::where('key', 'contract_handover_mail')->value('value');
        Mail::to($customerEmail)->send(new ContractDeliver($contract, $subject, $contractMailTemplate));
        $request->session()->forget('contractData');
        return redirect()->route('contracts');
    }
    
    
    public function ContractDeliverStoreBackStep1(Request $request)
    {
        $validatedData = $request;
        $contractId = $validatedData['contract_id'];
        $step = $validatedData['step'];
        $contract = Contract::findOrFail($contractId);
        
        
        // Oturumdan mevcut 'contractData' verilerini alın, eğer yoksa boş bir dizi oluşturun
        $contractData = session('contractData', []);
        
        // Belirtilen contractId için var olan verileri alın, yoksa boş bir dizi oluşturun
        $contractData[$contractId] = $contractData[$contractId] ?? [];
        
        // 'step' değerini güncelleyin
        $contractData[$contractId]['step'] = $step;
        
        // Güncellenmiş 'contractData' dizisini oturuma kaydedin
        session(['contractData' => $contractData]);
        
        return redirect()->back();
    }
    public function ContractDeliverStoreBackStep2(Request $request)
    {
        $validatedData = $request;
        $contractId = $validatedData['contract_id'];
        $step = $validatedData['step'];
        $contract = Contract::findOrFail($contractId);
        // Oturumdan mevcut 'contractData' verilerini alın, eğer yoksa boş bir dizi oluşturun
        $contractData = session('contractData', []);
        
        // Belirtilen contractId için var olan verileri alın, yoksa boş bir dizi oluşturun
        $contractData[$contractId] = $contractData[$contractId] ?? [];
        
        // 'step' değerini güncelleyin
        $contractData[$contractId]['step'] = $step;
        
        // Güncellenmiş 'contractData' dizisini oturuma kaydedin
        session(['contractData' => $contractData]);
        return redirect()->back();
    }
    public function ContractDeliverStoreBackStep3(Request $request)
    {
        $validatedData = $request;
        $contractId = $validatedData['contract_id'];
        $step = $validatedData['step'];
        $contract = Contract::findOrFail($contractId);
        
        $contractData[$contractId] = $contractData[$contractId] ?? [];
        
        $contractData[$contractId]['step'] = $step;
        session(['contractData' => $contractData]);
        
        return redirect()->back();
    }
    public function ContractDeliverStoreBackStep4(Request $request)
    {
        $validatedData = $request;
        
        $contractData = session('contractData', []);
        $step = $validatedData['step'];
        
        $contractData['step'] = $step;
        session(['contractData' => $contractData]);
        
        return redirect()->route('contracts.add');
    }
    public function ContractStoreWithoutSignature(Request $request)
    {
        $contractData = session('contractData', []);
        $companyId = auth()->user()->company_id;
        $contractId = $request->input('contract_id');
        $contract = Contract::find($contractId);
        $contract->status = 2;
        $customerData = $contract->customer;
        
        // Email'i alma
        $customerEmail = $customerData['email'];
        $customerName = $customerData['name'].''. $customerData['surname'];
        $companyName = auth()->user()->company->name;  // İlişki ile company bilgisi alınır
        
        $subject = $companyName . ' - Contract Handover for ' . $customerName;
        $contractMailTemplate = Setting::where('key', 'contract_handover_mail')->value('value');
        Mail::to($customerEmail)->send(new ContractDeliver($contract, $subject, $contractMailTemplate));
        $request->session()->forget('contractData');
        return redirect()->route('contracts');
    }
    public function ContractSign($id)
    {
        $user = auth()->user();
        $companyId = $user->company_id;
        
        // Sözleşmeyi bul ve şirket kimliğiyle kontrol et
        $contract = $user->company->contract()->where('id', $id)->first();
        
        if (!$contract) {
            // Eğer sözleşme bulunamazsa veya şirketle ilişkili değilse
            return redirect()->route('contracts')->with('error', 'Bu sözleşmeye erişim izniniz yok.');
        }
        
        $carData = json_decode($contract->car, true);
        $customerData = json_decode($contract->customer, true);
        $kmPackage = json_decode($contract->km_packages, true);
        $insurancePackage = json_decode($contract->insurance_packages, true);
        
        return view('company.contracts.contract-sign', compact('contract', 'carData', 'customerData', 'kmPackage', 'insurancePackage'));
    }
    public function ContractSignStore(Request $request, $id)
    {
        $user = auth()->user();        
        // Sözleşmeyi bul ve şirket kimliğiyle kontrol et
        $contract = $user->company->contract()->where('id', $id)->first();
        
        if (!$contract) {
            return redirect()->route('contracts')->with('error', 'You do not have permission to access this agreement.');
        }
        
        $signatureData = $request->input('signature');
        $imageData = explode(',', $signatureData)[1];
        $imageData = base64_decode($imageData);
        $fileName = 'signature_' . time() . '.png';
        $directory = public_path('assets/images/signatures');
        
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        $filePath = $directory . '/' . $fileName;
        file_put_contents($filePath, $imageData);
        $contractSignature = 'assets/images/signatures/' . $fileName;
        
        $contract->update([
            'signature' => $contractSignature,
            'status' => 1
        ]);
        $customerData = json_decode($contract->customer, true);
        
        // Email'i alma
        $customerEmail = $customerData['email'];
        $customerName = $customerData['name'].''. $customerData['surname'];
        $companyName = auth()->user()->company->name;  // İlişki ile company bilgisi alınır
        
        $subject = $companyName . ' - Contract Handover for ' . $customerName;
        $contractMailTemplate = Setting::where('key', 'contract_handover_mail')->value('value');
        Mail::to($customerEmail)->send(new ContractDeliver($contract, $subject, $contractMailTemplate));
        
        $request->session()->forget('contractData');
        return redirect()->route('contracts');
    }
    public function ContractDetail($id)
    {
        $user = auth()->user();
        $contract = $user->company->contract()->where('id', $id)->first();
        $carData = json_decode($contract->car, true);
        $pickupDamages = json_decode($contract->damages, true);
        $deliverOptions = is_string($carData['options']) ? json_decode($carData['options'], true) : $carData['options'];
        $pickupOptions = json_decode($contract->options, true);
        if (is_string($contract->customer)) {
            $customerData = json_decode($contract->customer, true); // JSON string ise diziye çevir
        } else {
            // Zaten bir dizi ise, doğrudan kullan
            $customerData = $contract->customer;
        }
        $kmPackage = json_decode($contract->km_packages, true);
        $insurancePackage = json_decode($contract->insurance_packages, true);
        $invoice = Invoice::where('contract_id', $contract->id)->first();
        return view('company.contracts.contract-detail',compact('contract','carData','pickupDamages','deliverOptions','pickupOptions','customerData','kmPackage','insurancePackage','invoice'));
    }
    public function resendContract(Contract $contract)
    {
        $customerJson = $contract->customer;
        $customerData = json_decode($customerJson, true);
        
        $customerEmail = $customerData['email'];
        $customerName = $customerData['name'].''. $customerData['surname'];
        $companyName = auth()->user()->company->name;  // İlişki ile company bilgisi alınır
        
        $subject = $companyName . ' - Contract Details for ' . $customerName;
        
        $contractMailTemplate = Setting::where('key', 'contract_add_mail')->value('value');
        
        Mail::to($customerEmail)->send(new ContractCreated($contract, $subject, $contractMailTemplate));
        
        return redirect()->back();
    }
    public function cancelContract($id)
    {
        $contract = Contract::findOrFail($id);
        
        $contract->status = 4;
        
        $contract->save();
        
        return redirect()->back();
    }
    
    public function getCarsByGroup($groupId)
    {
        $cars = Car::where('group_id', $groupId)->get();
        
        $carData = [];
        
        foreach ($cars as $car) {
            $contracts = Contract::where('car_id', $car->id)->get(['start_date', 'end_date']);
            
            $availability = $contracts->isEmpty() ? 'available' : 'unavailable';
            
            $carDetails = json_decode($car->car, true);
            $carPrices = json_decode($car->prices, true);
            $carData[] = [
                'id' => $car->id,
                'brand' => $carDetails['brand'], 
                'model' => $carDetails['model'], 
                'number_plate' => $car->number_plate,
                'prices' => $carPrices, 
                'contracts' => $contracts,
                'availability' => $availability,
            ];
        }
        
        return response()->json($carData);
    }
    
    
    public function ContractPickup($id)
    {
        // Contract verilerini veritabanından alın
        $contract = Contract::findOrFail($id);
        $customerId = $contract->customer_id;
        $customer = Customer::findOrFail($customerId);
        // Car verilerini alın ve JSON'dan dizilere çevirin
        $carDetailsJson = $contract->car;
        $carDetails = json_decode($carDetailsJson, true);
        $deliverOptions = json_decode($carDetails['options'], true);
        $carId = $carDetails['id'];
        $car = Car::findOrFail($carId);
        $carDamages = json_decode($contract->damages);
        
        
        $kmPackagesJson = json_decode($contract->km_packages, true);
        $insurancePackagesJson = json_decode($contract->insurance_packages, true);
        
        $carBrand = $carDetails['car']['brand'] ?? '';
        $carModel = $carDetails['car']['model'] ?? '';
        $deposito = $carDetails['prices']['deposito'] ?? '0';
        $oldDamagesArray = $carDetails['damages'];
        $oldInternalDamagesArray = $carDetails['internal_damages'] ?? [];
        // Eğer oldDamagesArray JSON string ise, önce array'e dönüştürün
        if (is_string($oldDamagesArray)) {
            $oldDamagesArray = json_decode($oldDamagesArray, true);
        }
        
        
        // OldDamagesArray'i NewDamagesArray formatına dönüştürme
        if (is_array($oldDamagesArray)) {
            $convertedOldDamagesArray = array_map(function($damage) {
                return [
                    'coordinates' => [
                        'x' => $damage['coordinates']['x'],
                        'y' => $damage['coordinates']['y']
                    ],
                    'description' => $damage['description'],
                    'photo' => $damage['photo']
                ];
            }, $oldDamagesArray);
        } else {
            // Eğer hala array değilse, uygun bir hata mesajı gösterin
            $convertedOldDamagesArray = [];
            // Hata durumu ile başa çıkmak için
            echo "OldDamagesArray bir diziye dönüştürülemedi.";
        }
        
        // Sonucu görüntüleme
        $newDamagesArray = json_decode($contract->damages, true);
        $newInternalDamagesArray = json_decode($contract->internal_damages, true);
        // Tarih aralığını hesaplayın
        $startDate = new \DateTime($contract->start_date);
        $endDate = new \DateTime($contract->end_date);
        $dateInterval = $startDate->diff($endDate);
        $days = $dateInterval->days;
        
        // Toplam fiyatı hesaplayın
        $dailyPrice = $carDetails['prices']['daily_price'] ?? 0;
        $subTotalPrice = $dailyPrice * $days;
        $contractData = session('contractData', []);
        
        return view('company.contracts.contract-pickup', compact('carBrand', 'customer','deliverOptions', 'contractData', 'contract', 'carDetails', 'carModel', 'days', 'subTotalPrice', 'kmPackagesJson', 'insurancePackagesJson', 'deposito', 'oldDamagesArray', 'newDamagesArray','oldInternalDamagesArray','newInternalDamagesArray'));
        
    }
    
    public function ContractPickupStore(Request $request)
    {
        $request->validate([
            'odometer' => 'required|numeric',
            'extra_km' => 'required|numeric',
            'pickup_date_contract' => 'required',
            'end_date_contract' => 'required',
            'options' => 'required|array',
            'options.*' => 'required|string',
        ]);
        $contract = Contract::find($request->input('contract_id'));
        $car = Car::find($contract->car_id);
        
        $internalDamages = [];
        
        // Formdaki tüm iç hasar verilerini işleyelim
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'internal_damage_description_') !== false) {
                $damageIndex = str_replace('internal_damage_description_', '', $key);
                $description = $request->input('internal_damage_description_' . $damageIndex);
                
                if ($request->hasFile('internal_damage_image_' . $damageIndex)) {
                    $file = $request->file('internal_damage_image_' . $damageIndex);
                
                    // Dosya uzantısını almak için
                    $extension = $file->getClientOriginalExtension(); // Örneğin, jpg, png, vb.
                
                    // Benzersiz dosya adı oluştur
                    $fileName = uniqid() . '.' . $extension; 
                    $file->move(public_path('assets/images/internal_damages/'), $fileName);
                    
                    $internalDamages[] = [
                        'description' => $description,
                        'image' => 'assets/images/internal_damages/' . $fileName,  // Doğru dizin
                    ];
                }
            }
        }
        // Mevcut iç hasarlar varsa, yenileriyle birleştir
        $existingInternalDamages = json_decode($car->internal_damages, true) ?? [];
        $mergedInternalDamages = array_merge($existingInternalDamages, $internalDamages);
        // Check if the contract exists
        if (!$contract) {
            return redirect()->back()->with('error', 'Contract not found.');
        }
        
        // Update the contract with the form data
        $existingDamages = [];
        $index = 1;
        
        while ($request->has("old_description_$index")) {
            $existingDamages[] = [
                'coordinates' => [
                    'x' => $request->input("old_x_cordinate_$index"),
                    'y' => $request->input("old_y_cordinate_$index")
                ],
                'description' => $request->input("old_description_$index"),
                'photo' => $request->input("old_image_$index")
            ];
            $index++;
        }
        
        $newDamages = [];
        $index = 1;
        
        while ($request->has("damage-description-$index")) {
            $description = $request->input("damage-description-$index");
            $xCoordinate = $request->input("x-coordinate-$index");
            $yCoordinate = $request->input("y-coordinate-$index");
            $photo = $request->file("damage-photo-$index");
            
            $photoPath = null;
            if ($photo) {
                $destinationPath = public_path('assets/images/damages');
                
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                
                $fileName = time() . '-' . $photo->getClientOriginalName();
                $photo->move($destinationPath, $fileName);
                $photoPath = 'assets/images/damages/' . $fileName;
            }
            
            // Yeni hasar bilgilerini dizine ekle
            $newDamages[] = [
                'coordinates' => ['x' => $xCoordinate, 'y' => $yCoordinate],
                'description' => $description,
                'photo' => $photoPath,
            ];
            
            $index++;
        }
        $allDamages = array_merge($existingDamages, $newDamages);
        
        $options = json_encode($request->input('options'), JSON_UNESCAPED_UNICODE);
        
        $base64Image = $request->input('damage_image');
        
        if ($base64Image) {
            if (strpos($base64Image, 'data:image/png;base64,') === 0) {
                list($type, $data) = explode(',', $base64Image, 2);
                
                $imageData = base64_decode($data);
                
                if ($imageData === false) {
                    return redirect()->back()->with('error', 'Base64 verisi decode edilemedi.');
                }
                
                $fileName = 'damage_image_' . time() . '.png';
                
                $filePath = 'assets/images/damages/canvas/' . $fileName;
                
                // Public dizin altındaki dosya yolunu oluştur
                $fullPath = public_path($filePath);
                
                
                $saved = file_put_contents($filePath, $imageData);
                
                $contract->pickup_damages_image = $filePath;
            } else {
                return redirect()->back()->with('error', 'Geçersiz Öğe.');
            }
        }
        // Veritabanına güncellenmiş hasarları kaydet
        $contract->damages = json_encode($allDamages);
        $contract->internal_damages = json_encode($mergedInternalDamages);
        $contract->fuel_status = $request->input('fuel_status');
        $contract->extra_km = $request->input('extra_km');
        $contract->extra_km_price = $request->input('extra_km_price');
        $contract->pickup_date = $request->input('pickup_date_contract');
        $contract->status = 5;
        $contract->options = $options;
        // Save the changes
        $contract->save();
        $car->odometer = $request->input('odometer');
        $car->save();
        
        if (is_string($contract->customer)) {
            $customerData = json_decode($contract->customer, true); // JSON string ise diziye çevir
        } else {
            // Zaten bir dizi ise, doğrudan kullan
            $customerData = $contract->customer;
        }
        
        // Email'i alma
        $customerEmail = $customerData['email'];
        $customerName = $customerData['name'].''. $customerData['surname'];
        $companyName = auth()->user()->company->name;  // İlişki ile company bilgisi alınır
        
        $subject = $companyName . ' - Contract Pickup for ' . $customerName;
        $contractMailTemplate = Setting::where('key', 'contract_pickup_mail')->value('value');
        Mail::to($customerEmail)->send(new ContractPickup($contract,$subject, $contractMailTemplate));
        // Redirect with a success message
        return redirect()->route('contracts')->with('success', 'Contract updated successfully.');
    }
    public function ContractExtraDate($id)
    {
        $user = auth()->user();
        $contract = $user->company->contract()->where('id', $id)->first();
        return view('company.contracts.contract-extradate',compact('contract'));
    }
    public function ContractExtraDateSend(Request $request)
    {
        // Veri doğrulama
        $validatedData = $request;
        
        // Verileri al
        $contractId = $validatedData['contract_id'];
        $extraDate = $validatedData['extra_date'];
        
        // Kontratı bul ve güncelle
        $contract = Contract::find($contractId);
        if ($contract) {
            $contract->extra_date = $extraDate;
            $contract->save();
            
            // Başarı mesajı ile yönlendirme
            return redirect()->route('contracts')->with('success', 'Contract updated successfully.');
        } else {
            // Kontrat bulunamazsa hata mesajı ile yönlendirme
            return redirect()->route('contracts')->with('error', 'Contract not found.');
        }
    }
    public function ContractPdf($id)
    {
        $user = auth()->user();
        $contract = $user->company->contract()->where('id', $id)->first();
        
        // Şirket kontrolü
        if ($user->company->id != $contract->company_id) {
            return redirect()->route('contracts')->with('error', 'Sie sind nicht berechtigt, auf diese Vereinbarung zuzugreifen.');
        }
        
        // Verileri çözümleme
        $carJson = json_decode($contract->car, true);
        if (is_string($contract->customer)) {
            $customerJson = json_decode($contract->customer, true); // JSON string ise diziye çevir
        } else {
            // Zaten bir dizi ise, doğrudan kullan
            $customerJson = $contract->customer;
        }
        $kmPackages = json_decode($contract->km_packages, true);
        $insurancePackages = json_decode($contract->insurance_packages, true);
        $damages = json_decode($contract->damages, true);
        $options = json_decode($contract->options, true);
        
        // Araç bilgileri
        $carBrand = $carJson['car']['brand'] ?? 'N/A';
        $carModel = $carJson['car']['model'] ?? 'N/A';
        $licensePlate = $carJson['number_plate'] ?? 'N/A';
        
        // Şirket logosu
        $companyLogo = $user->company->logo;
        
        // Opsiyonel ayarları çözümleme
        $warningTriangle = $options['triangle_reflector'] ?? 'N/A';
        $warningVest = $options['reflective_vest'] ?? 'N/A';
        $firstAidKit = $options['first_aid_kit'] ?? 'N/A';
        $carCleanliness = $options['clean'] ?? 'N/A';
        $tireTread = $options['tire_profile'] ?? 'N/A';
        
        // Bugünün tarihini ekleme
        $todayDate = now()->format('d.m.Y');
        
        // PDF oluşturma
        $pdf = PDF::loadView('pdf.contractDeliver', [
            'contract' => $contract,
            'companyLogo' => $companyLogo,
            'carModel' => $carBrand . ' ' . $carModel,
            'licensePlate' => $licensePlate,
            'returnDate' => $contract->end_date, // Geri dönüş tarihi
            'damages' => $damages ?? [],
            'damageImages' => array_map(function($damage) {
                return asset($damage['photo'] ?? '');
            }, $damages ?? []),
            'warningTriangle' => $warningTriangle,
            'warningVest' => $warningVest,
            'firstAidKit' => $firstAidKit,
            'carCleanliness' => $carCleanliness,
            'tireTread' => $tireTread,
            'todayDate' => $todayDate,
            'customer' => $customerJson, // Müşteri bilgilerini ekleme
            'kmPackages' => $kmPackages,
            'insurancePackages' => $insurancePackages,
        ]);
        
        // PDF dosyasını indir
        return $pdf->download('Contract-Handover.pdf');
    }
    protected function sanitizeFileName($fileName)
    {
        // Türkçe karakterleri İngilizceye çevir
        $fileName = str_replace(
            ['Ç', 'ç', 'Ğ', 'ğ', 'İ', 'ı', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü'],
            ['C', 'c', 'G', 'g', 'I', 'i', 'O', 'o', 'S', 's', 'U', 'u'],
            $fileName
        );
        
        // Boşlukları alt çizgiye çevir ve özel karakterleri kaldır
        $fileName = preg_replace('/[^A-Za-z0-9\-_\.]/', '', str_replace(' ', '_', $fileName));
        
        // Aynı dosya uzantısını kullanmak için dosya uzantısını ayrıştır
        return pathinfo($fileName, PATHINFO_FILENAME);
    }
}
