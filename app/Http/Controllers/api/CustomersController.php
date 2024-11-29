<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomersController extends Controller
{
    public function getCustomerByCompany()
    {
        // Şirketlere göre gruplanmış araçlar
        $companies = Company::with('customers')->get();
        
        // Şirket ID'sine göre gruplandırılmış bir array yapısı
        $result = [];
        
        foreach ($companies as $company) {
            $result[$company->id] = [
                'company_name' => $company->name,
                'customers' => $company->customers->map(function ($customer) {
                    return [
                        'id' => $customer->id,
                        'car' => $customer->car,
                        'company_id' => $customer->company_id,
                        'name' => $customer->name,
                        'surname' => $customer->surname,
                        'date_of_birth' => $customer->date_of_birth,
                        'identity' => $customer->identity,
                        'driving_licence' => $customer->driving_licence,
                        'company_name' => $customer->company_name,
                        'phone' => $customer->phone,
                        'email' => $customer->email,
                        'address' => $customer->address,
                        'invoice_status' => $customer->invoice_status,
                        'invoice_info' => $customer->invoice_info,
                        'status' => $customer->status,
                        'created_at' => $customer->standard_exemption,
                        'updated_at' => $customer->age
                    ];
                })->toArray(),
            ];
        }
        
        return response()->json($result);
    }

    public function CustomerStore(Request $request)
    {

        $apiToken = $request->header('Authorization');
    
        if (!$this->isValidApiToken($apiToken)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validatedData = $request;
        $customer = Customer::create([
            'company_id' => 1,
            'name' => $validatedData['name'],
            'surname' => $validatedData['surname'],
            'status' => 2,
            'address' => json_encode([
                'country' => 'not',
                'city' => 'not',
                'street' => 'not',
                'zip_code' => 'not',
            ]),
            'invoice_status' => 1,
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email']
            
        ]);
        return response()->json(['success' => 'Customer created successfully!'], 201);
    }

    private function isValidApiToken($apiToken)
    {
        $validToken = '144qwe4qwe412';
        
        return $apiToken === 'Bearer ' . $validToken;
    }
}
