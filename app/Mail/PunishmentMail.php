<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PunishmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $punishment;
    public $company;
    public $mailTemplate;

    /**
     * Create a new message instance.
     */
    public function __construct($punishment, $company, $mailTemplate)
    {
        $this->punishment = $punishment;
        $this->company = $company;
        $this->mailTemplate = $mailTemplate;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $customerId = $this->punishment->customer_id; // Customer ID'yi alıyoruz
        $customerData = Customer::find($customerId); // Bu ID'ye göre müşteriyi buluyoruz
        $customerAddress = $customerData['address'];
        if(is_string($customerAddress)){
            $customerAddress = json_decode($customerData['address'], true);
        }else{
            $customerAddress = $customerData['address'];
        }
        // Şablon yer tutucularını gerçek verilerle değiştir
        $content = str_replace(
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
                '{{ $punishment->description }}',
                '*Customer_Name',
                '*Customer_Surname',
                '*Customer_Email',
                '*Customer_Phone',
                '*Customer_Country',
                '*Customer_City',
                '*Customer_Street',
                '*Customer_Zip_Code',
            ], 
            [
                $this->punishment->contract_id, 
                $this->punishment->car_id, 
                $this->punishment->customer_id, 
                $this->punishment->punishment, 
                $this->punishment->car, 
                $this->punishment->driver, 
                $this->punishment->start_date, 
                $this->punishment->end_date, 
                $this->punishment->pickup_date, 
                $this->punishment->description,
                $customerData->name,
                $customerData->surname,
                $customerData->email,
                $customerData->phone,
                $customerAddress['country'],
                $customerAddress['city'],
                $customerAddress['street'],
                $customerAddress['zip_code'],
            ], 
            $this->mailTemplate
        );

        return $this->view('emails.punishment') // Boş bir Blade dosyası, çünkü dinamik mail içeriği oluşturulacak.
                    ->subject($this->company . ' - Punishment Notification')
                    ->with([
                        'content' => $content,
                    ]);
    }
}