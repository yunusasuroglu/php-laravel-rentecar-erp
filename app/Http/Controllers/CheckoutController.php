<?php

namespace App\Http\Controllers;

use App\Mail\ContractCreated;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    public function CheckoutForm()
    {
        $contractData = session('contract_data');
        Stripe::setApiKey(env('STRIPE_SECRET'));
        
        if($contractData){
            // dd($contractData);
            $amount = str_replace(',', '.', $contractData['total_amount']);
            
            $amountInCents = intval(floatval($amount) * 100);
            $paymentIntent = PaymentIntent::create([
                'amount' => $amountInCents, // Miktar cent cinsinden, burada 19,99 EUR.
                'currency' => 'eur',
                'automatic_payment_methods' => ['enabled' => true],
            ]);
            
            if (is_string($contractData['car'])) {
                $carData = json_decode($contractData['car'], true); // JSON string ise diziye çevir
            } else {
                // Zaten bir dizi ise, doğrudan kullan
                $carData = $contractData['car'];
            }
            if (is_string($contractData['customer'])) {
                $customerData = json_decode($contractData['customer'], true); // JSON string ise diziye çevir
            } else {
                // Zaten bir dizi ise, doğrudan kullan
                $customerData = $contractData['customer'];
            }
            $kmPackage = json_decode($contractData['km_packages'], true);
            $insurancePackage = json_decode($contractData['insurance_packages'], true);
            $carName = $carData['car']['brand'] . ' ' . $carData['car']['model'];
            $startDate = Carbon::parse($contractData['start_date']);
            $endDate = Carbon::parse($contractData['end_date']);
            
            // Farkı gün cinsinden hesapla
            $days = $startDate->diffInDays($endDate);
            return view('book.checkout',compact('paymentIntent','contractData','carData','customerData','kmPackage','insurancePackage','carName','days'));
        }else{
            return view('book.book');
        }
        
    }
    public function CheckoutSuccess(Request $request)
    {
        {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            
            // URL'den gelen payment_intent parametresini al
            $paymentIntentId = $request->query('payment_intent');
            
            // Payment Intent'ı Stripe üzerinden kontrol et
            try {
                $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
                
                // Ödeme başarılı mı kontrol et
                if ($paymentIntent->status === 'succeeded') {
                    // Sözleşme verilerini session'dan al
                    $contractData = session('contract_data');
                    // dd($contractData);
                    if ($contractData) {
                        // Sözleşmeyi oluştur
                        if (is_string($contractData['car'])) {
                            $carData = json_decode($contractData['car'], true); // JSON string ise diziye çevir
                        } else {
                            // Zaten bir dizi ise, doğrudan kullan
                            $carData = $contractData['car'];
                        }
                        if (is_string($contractData['customer'])) {
                            $customerData = json_decode($contractData['customer'], true); // JSON string ise diziye çevir
                        } else {
                            // Zaten bir dizi ise, doğrudan kullan
                            $customerData = $contractData['customer'];
                        }
                        $contract = new Contract();
                        $contract->company_id = $contractData['company_id'];
                        $contract->car = json_encode($contractData['car'], true);
                        $contract->customer = json_encode($customerData, true);
                        $contract->car_group = $contractData['car_group'];
                        $contract->car_id = $contractData['car_id'];
                        $contract->customer_id = $customerData['id']; // not
                        
                        $contract->km_packages = $contractData['km_packages'];
                        $contract->insurance_packages = $contractData['insurance_packages'];
                        
                        $contract->discount = '0'; // Varsayılan olarak 0
                        $contract->payment_option = $contractData['payment_option'];
                        $contract->payment_intent = $paymentIntentId;
                        $contract->start_date = $contractData['start_date'];
                        $contract->end_date = $contractData['end_date'];
                        $contract->tax = $contractData['tax'];
                        $contract->amount_paid = $contractData['total_amount'];
                        $contract->remaining_paid = 0;
                        $contract->description = 'web';
                        $contract->total_amount = $contractData['total_amount'];
                        $contract->car_subtotal_price = $contractData['total_amount'];
                        $contract->deposit = $contractData['deposit'];
                        $contract->status = 3; // Varsayılan olarak 3
                        $contract->fuel_status = $carData['fuel_status'];
                        $contract->damages = json_encode($carData['damages'], true);
                        $contract->internal_damages = json_encode($carData['internal_damages'], true);
                        $contract->options = json_encode($carData['options'],true);
                        
                        
                        $contract->save();
                        // Sözleşme başarıyla oluşturuldu
                        $customerEmail = $customerData['email'];
                        $customerName = $customerData['name'].''. $customerData['surname'];
                        $company = Company::find(1);
                        $companyName = $company->name;  // İlişki ile company bilgisi alınır
                        
                        $subject = $companyName . ' - Contract Add for ' . $customerName;
                        $contractMailTemplate = Setting::where('key', 'contract_add_mail')->value('value');
                        
                        Mail::to($customerEmail)->send(new ContractCreated($contract, $subject, $contractMailTemplate));

                        $request->session()->forget('contract_data');
                        return view('book.success', ['message' => 'The contract has been completed successfully.']);
                    } else {
                        return view('book.index');
                    }
                } else {
                    // Ödeme başarısızsa hata mesajı döndür
                    return view('book.success', ['message' => 'Ödeme başarısız oldu.']);
                }
            } catch (\Exception $e) {
                // Hata olursa hata mesajı döndür
                return view('book.success', ['message' => 'Ödeme doğrulama sırasında bir hata oluştu: ' . $e->getMessage()]);
            }
        }
    }
    public function CheckoutError()
    {
        return view('book.error');
    }
}