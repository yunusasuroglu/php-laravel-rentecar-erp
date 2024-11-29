<?php

namespace App\Http\Controllers\Company\Punishment;

use App\Http\Controllers\Controller; // Bu satırı eklemeyi unutmayın
use App\Models\Contract;
use App\Models\Punishment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PunishmentMail;
use Illuminate\Support\Facades\Auth;

class PunishmentController extends Controller
{

    public function Punishment()
    {
        // Giriş yapmış kullanıcıyı al
        $user = Auth::user();
    
        $company = $user->company;
    
        $contracts = $company->contract()->where('status', 6)->get();
        // Verileri view'e gönder
        return view('company.punishments.punishment-add', compact('company', 'contracts'));
    }
    public function getContract($id)
    {
        // Sözleşmeyi çek ve müşteri bilgilerini JSON olarak döndür
        $contract = Contract::with('customer')->find($id);

        if ($contract) {
            // İlişkili müşteri bilgilerini döndür
            if (is_string($contract->customer)) {
                $customerData = json_decode($contract->customer, true); // JSON string ise diziye çevir
            } else {
                // Zaten bir dizi ise, doğrudan kullan
                $customerData = $contract->customer;
            }
            $customerIdCards = $customerData['identity'];
            $customerDrivingCards = $customerData['driving_licence'];
            $carData = json_decode($contract->car, true);
            $carName = $carData['car'];

            return response()->json([
                'id' => $contract->id,
                'customer' => [
                    'id' => $customerData['id'],
                    'name' => $customerData['name'],
                    'surname' => $customerData['surname'],
                    'identity_front' => $customerIdCards['front'],
                    'identity_back' => $customerIdCards['back'],
                    'driving_front' => $customerDrivingCards['front'],
                    'driving_back' => $customerDrivingCards['back'],
                    'phone' => $customerData['phone'],
                    'email' => $customerData['email'],
                ],
                'car' => [
                    'id' => $carData['id'],
                    'brand' => $carName['brand'],
                    'model' => $carName['model'],
                    'plate' => $carData['number_plate']
                ],
                'start_date' => $contract->start_date,
                'end_date' => $contract->end_date,
                'pickup_date' => $contract->pickup_date
            ]);
        } else {
            return response()->json(['error' => 'Contract not found'], 404);
        }
    }
    
    public function PunishmentStore(Request $request)
    {
        $user = Auth::user();
    
        $company = $user->company;
        $validatedData = $request;

        $punishment = new Punishment();

        $punishment->contract_id = $validatedData['contract_id'];
        $punishment->car_id = $validatedData['car_id'];
        $punishment->customer_id = $validatedData['customer_id'];
        $punishment->company_id = $company->id;

        $punishment->corporate_email = $validatedData['email'];
        $punishment->punishment = $validatedData['punishment'];
        $punishment->description = $validatedData['description'];
        $punishment->car = $validatedData['car'];
        $punishment->driver = $validatedData['driver'];
        $punishment->start_date = $validatedData['start_date'];
        $punishment->end_date = $validatedData['end_date'];
        $punishment->pickup_date = $validatedData['pickup_date'];

        $punishment->save();
        $punishmentMailTemplate = Setting::where('key', 'punishment_mail')->value('value');
        $punishmentMailContent = str_replace(
            [
                '{{ $punishment->contract_id }}', 
                '{{ $punishment->car_id }}', 
                '{{ $punishment->customer_id }}', 
                '{{ $punishment->punishment }}', 
                '{{ $punishment->car }}', 
                '{{ $punishment->driver }}', 
                '{{ $punishment->start_date }}', 
                '{{ $punishment->end_date }}', 
                '{{ $punishment->pickup_date }}',
                '{{ $punishment->description }}'
            ], 
            [
                $punishment->contract_id, 
                $punishment->car_id, 
                $punishment->customer_id, 
                $punishment->punishment, 
                $punishment->car, 
                $punishment->driver, 
                $punishment->start_date, 
                $punishment->end_date, 
                $punishment->pickup_date, 
                $punishment->description
            ], 
            $punishmentMailTemplate
        );
        Mail::to($validatedData['email'])->send(new PunishmentMail($punishment, $company->name, $punishmentMailTemplate));
        // Başarılı işlem mesajı ile yönlendirme
        return redirect()->back()->with('success', 'Punishment information has been updated successfully!');
    }
    public function Punishments()
{
    // Giriş yapmış kullanıcıyı al
    $user = Auth::user();
    
    $company = $user->company;

    $punishments = $company->punishments()->get();

    return view('company.punishments.punishments', compact('company', 'punishments'));
}
}
