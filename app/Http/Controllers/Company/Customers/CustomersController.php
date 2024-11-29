<?php

namespace App\Http\Controllers\Company\Customers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;

class CustomersController extends Controller
{
    public function Customers()
    {
        // Giriş yapmış kullanıcıyı al
        $user = Auth::user();
        
        // Giriş yapmış kullanıcının şirketine ait müşterileri çek
        $customers = $user->company->customers;
        
        // Müşterilerin yaşlarını hesapla ve müşteri ile birlikte sakla
        $customersWithAge = $customers->map(function ($customer) {
            // Yaş hesaplama
            if (!empty($customer->date_of_birth)) {
                $birthDate = Carbon::parse($customer->date_of_birth);
                $customer->age = $birthDate->diffInYears(Carbon::now());
            } else {
                $customer->age = 'N/A';
            }
            
            // Son kiralanan aracı bulma
            $lastContract = $customer->contract()->latest()->first();
            if ($lastContract && $lastContract->car) {
                $customer->last_rented_car = $lastContract->car; // Aracın modelini ekleyin
            } else {
                $customer->last_rented_car = 'No rentals'; // Eğer kiralama yoksa
            }
            
            return $customer;
        });
        // Görünümü müşteriler ile birlikte döndür
        return view('company.customers.customers', compact('customersWithAge'));
    }
    public function CustomerDetail($id)
    {
        // Belirtilen ID'ye sahip müşteriyi bulun
        $customer = Customer::findOrFail($id);
        $title = $customer->name . ' ' . $customer->surname;
        $birthDate = Carbon::parse($customer->date_of_birth);
        $age = $birthDate->diffInYears(Carbon::now());
        $invoices = $customer->invoices;
        $contracts = $customer->contract;
        $carName = [];
        foreach($invoices as $invoice){
            $carName = json_decode($invoice->items, true);
        }
        return view('company.customers.customer-detail', compact('customer','contracts','title','age','invoices','carName'));
    }
    public function CustomerEdit($id)
    {
        // Belirtilen ID'ye sahip müşteriyi bulun
        $customer = Customer::findOrFail($id);
        $title = $customer->name . ' ' . $customer->surname;
        $birthDate = Carbon::parse($customer->date_of_birth);
        $age = $birthDate->diffInYears(Carbon::now());
        return view('company.customers.customer-edit', compact('customer','title','age'));
    }
    public function CustomerAdd()
    {
        return view('company.customers.customer-add');
    }
    
    public function CustomerStore(Request $request)
    {
        // Doğrulama kuralları
        $validatedData = $request->validate([
            'company_name' => 'string|max:255',
            'name' => 'string|max:255',
            'surname' => 'string|max:255',
            'street' => 'string|max:255',
            'zip_code' => 'string|max:20',
            'city' => 'string|max:255',
            'country' => 'string|max:255',
            'date_of_birth' => 'date',
            'identity_expiry_date' => 'date',
            'driver_licence_expiry_date' => 'date',
            'invoice_address_active' => 'nullable|boolean',
            'invoice_company_name' => 'nullable|string|max:255',
            'invoice_name' => 'nullable|string|max:255',
            'invoice_surname' => 'nullable|string|max:255',
            'invoice_street' => 'nullable|string|max:255',
            'invoice_zip_code' => 'nullable|string|max:20',
            'invoice_city' => 'nullable|string|max:255',
            'invoice_country' => 'nullable|string|max:255',
            'phone' => 'string|max:20',
            'email' => 'string|email|max:255',
        ]);
        
        // Dosya yükleme işlemi
        // Dosya yolları
        $identityFrontName = uniqid() . '.' . $request->file('identity_front')->getClientOriginalExtension();
        $identityBackName = uniqid() . '.' . $request->file('identity_back')->getClientOriginalExtension();
        $driverLicenceFrontName = uniqid() . '.' . $request->file('driver_licence_front')->getClientOriginalExtension();
        $driverLicenceBackName = uniqid() . '.' . $request->file('driver_licence_back')->getClientOriginalExtension();
        
        // Dosya yolları
        $identityFrontPath = 'assets/images/identity/' . $identityFrontName;
        $identityBackPath = 'assets/images/identity/' . $identityBackName;
        $driverLicenceFrontPath = 'assets/images/licence/' . $driverLicenceFrontName;
        $driverLicenceBackPath = 'assets/images/licence/' . $driverLicenceBackName;
        
        // Dosyaları taşıma
        $request->file('identity_front')->move(public_path('assets/images/identity'), $identityFrontName);
        $request->file('identity_back')->move(public_path('assets/images/identity'), $identityBackName);
        $request->file('driver_licence_front')->move(public_path('assets/images/licence'), $driverLicenceFrontName);
        $request->file('driver_licence_back')->move(public_path('assets/images/licence'), $driverLicenceBackName);
        
        if ($request->input('invoice_address_active')) {
            $invoiceInfo = [
                'company_name' => $validatedData['invoice_company_name'],
                'name' => $validatedData['invoice_name'],
                'surname' => $validatedData['invoice_surname'],
                'country' => $validatedData['invoice_country'],
                'city' => $validatedData['invoice_city'],
                'street' => $validatedData['invoice_street'],
                'zip_code' => $validatedData['invoice_zip_code'],
            ];
            $status = 2;
        } else {
            $invoiceInfo = [
                'company_name' => $validatedData['company_name'],
                'name' => $validatedData['name'],
                'surname' => $validatedData['surname'],
                'country' => $validatedData['country'],
                'city' => $validatedData['city'],
                'street' => $validatedData['street'],
                'zip_code' => $validatedData['zip_code'],
            ];
            $status = 1;
        }
        $companyId = Auth::user()->company_id;
        // Customer modelini oluşturma ve kaydetme
        $customer = Customer::create([
            'company_name' => $validatedData['company_name'],
            'company_id' => $companyId,
            'name' => $validatedData['name'],
            'surname' => $validatedData['surname'],
            'status' => 2, // Varsayılan olarak aktif durumu
            'address' => json_encode([
                'country' => $validatedData['country'],
                'city' => $validatedData['city'],
                'street' => $validatedData['street'],
                'zip_code' => $validatedData['zip_code'],
            ]),
            'invoice_info' => json_encode($invoiceInfo),
            'invoice_status' => $status,
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'driving_licence' => json_encode([
                'front' => $driverLicenceFrontPath,
                'back' => $driverLicenceBackPath,
                'expiry_date' => $validatedData['driver_licence_expiry_date'],
            ]),
            'identity' => json_encode([
                'front' => $identityFrontPath,
                'back' => $identityBackPath,
                'expiry_date' => $validatedData['identity_expiry_date'],
            ]),
            
        ]);
        // dd($customer);
        return redirect()->route('customers')->with('success', 'Customer created successfully.');
    }
    public function CustomerUpp(Request $request, $id)
    {
        $customer =  Customer::find($id);
        // Doğrulama kuralları
        $validatedData = $request->validate([
            'company_name' => 'string|max:255',
            'name' => 'string|max:255',
            'surname' => 'string|max:255',
            'street' => 'string|max:255',
            'zip_code' => 'string|max:20',
            'city' => 'string|max:255',
            'country' => 'string|max:255',
            'date_of_birth' => 'date',
            'identity_expiry_date' => 'date',
            'driver_licence_expiry_date' => 'date',
            'invoice_address_active' => 'nullable|boolean',
            'invoice_company_name' => 'nullable|string|max:255',
            'invoice_name' => 'nullable|string|max:255',
            'invoice_surname' => 'nullable|string|max:255',
            'invoice_street' => 'nullable|string|max:255',
            'invoice_zip_code' => 'nullable|string|max:20',
            'invoice_city' => 'nullable|string|max:255',
            'invoice_country' => 'nullable|string|max:255',
            'phone' => 'string|max:20',
            'email' => 'string|email|max:255',
        ]);
        
        // Dosya yükleme işlemi
        // Dosya yolları
        $identityFrontName = uniqid() . '.' . $request->file('identity_front')->getClientOriginalExtension();
        $identityBackName = uniqid() . '.' . $request->file('identity_back')->getClientOriginalExtension();
        $driverLicenceFrontName = uniqid() . '.' . $request->file('driver_licence_front')->getClientOriginalExtension();
        $driverLicenceBackName = uniqid() . '.' . $request->file('driver_licence_back')->getClientOriginalExtension();
        
        // Dosya yolları
        $identityFrontPath = 'assets/images/identity/' . $identityFrontName;
        $identityBackPath = 'assets/images/identity/' . $identityBackName;
        $driverLicenceFrontPath = 'assets/images/licence/' . $driverLicenceFrontName;
        $driverLicenceBackPath = 'assets/images/licence/' . $driverLicenceBackName;
        
        // Dosyaları taşıma
        $request->file('identity_front')->move(public_path('assets/images/identity'), $identityFrontName);
        $request->file('identity_back')->move(public_path('assets/images/identity'), $identityBackName);
        $request->file('driver_licence_front')->move(public_path('assets/images/licence'), $driverLicenceFrontName);
        $request->file('driver_licence_back')->move(public_path('assets/images/licence'), $driverLicenceBackName);
        
        if ($request->input('invoice_address_active')) {
            $invoiceInfo = [
                'company_name' => $validatedData['invoice_company_name'],
                'name' => $validatedData['invoice_name'],
                'surname' => $validatedData['invoice_surname'],
                'country' => $validatedData['invoice_country'],
                'city' => $validatedData['invoice_city'],
                'street' => $validatedData['invoice_street'],
                'zip_code' => $validatedData['invoice_zip_code'],
            ];
            $status = 2;
        } else {
            $invoiceInfo = [
                'company_name' => $validatedData['company_name'],
                'name' => $validatedData['name'],
                'surname' => $validatedData['surname'],
                'country' => $validatedData['country'],
                'city' => $validatedData['city'],
                'street' => $validatedData['street'],
                'zip_code' => $validatedData['zip_code'],
            ];
            $status = 1;
        }
        $companyId = Auth::user()->company_id;
        // Customer modelini oluşturma ve kaydetme
        $customer->update([
            'company_name' => $validatedData['company_name'],
            'company_id' => $companyId,
            'name' => $validatedData['name'],
            'surname' => $validatedData['surname'],
            'status' => 2, // Varsayılan olarak aktif durumu
            'address' => json_encode([
                'country' => $validatedData['country'],
                'city' => $validatedData['city'],
                'street' => $validatedData['street'],
                'zip_code' => $validatedData['zip_code'],
            ]),
            'invoice_info' => json_encode($invoiceInfo),
            'invoice_status' => $status,
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'driving_licence' => json_encode([
                'front' => $driverLicenceFrontPath,
                'back' => $driverLicenceBackPath,
                'expiry_date' => $validatedData['driver_licence_expiry_date'],
            ]),
            'identity' => json_encode([
                'front' => $identityFrontPath,
                'back' => $identityBackPath,
                'expiry_date' => $validatedData['identity_expiry_date'],
            ]),
        ]);
        // dd($customer);
        return redirect()->route('customers')->with('success', 'Customer created successfully.');
    }
}
