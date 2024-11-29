<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;
use Carbon\Carbon;

class ContractPickup extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $contract;
    public $subject;
    public $contractMailTemplate;
    
    /**
    * Create a new message instance.
    *
    * @param  $contract
    * @return void
    */
    public function __construct($contract, $subject, $contractMailTemplate)
    {
        $this->contract = $contract;
        $this->subject = $subject;
        $this->contractMailTemplate = $contractMailTemplate;
    }
    
    /**
    * Build the message.
    *
    * @return $this
    */
    public function build()
    {
        
        // Önceden oluşturulmuş PDF dosyalarının yollarını belirleyin
        $pdf1Path = storage_path('app/public/pdfs/disclaimer_de_1.pdf');
        $pdf2Path = storage_path('app/public/pdfs/agb_de_1.pdf');
        
        // JSON verilerini dizilere dönüştür
        $carJson = json_decode($this->contract->car, true);
        $pickupOptions = json_decode($this->contract->options, true);
        $pickupDamages = json_decode($this->contract->damages, true);
        $internalPickupDamages = json_decode($this->contract->internal_damages, true);
        $pdf3 = PDF::loadView('pdf.contractPickupPdf', [
            'contract' => $this->contract,
            'insurancePackage' => json_decode($this->contract->insurance_packages, true),
            'kilometerPackage' => json_decode($this->contract->km_packages, true),
            'carModel' => ($carJson['car']['brand'] ?? 'N/A') . ' ' . ($carJson['car']['model'] ?? 'N/A'),
            'licensePlate' => $carJson['number_plate'] ?? 'N/A',
            'returnDate' => $this->contract->end_date,
            'returnTime' => Carbon::parse($this->contract->end_date)->format('H:i'),
            'returnDay' => Carbon::parse($this->contract->end_date)->diffInDays(Carbon::parse($this->contract->start_date)),
            
            'pickupDamage' => implode(', ', array_map(function($damage) {
                return $damage['description'] ?? '';
            }, $pickupDamages ?? [])),
            'pickupDamageImages' => array_map(function($damage) {
                return asset($damage['photo'] ?? '');
            }, $pickupDamages ?? []),

            'internalPickupDamage' => implode(', ', array_map(function($internal_damage) {
                return $internal_damage['description'] ?? '';
            }, $internalPickupDamages ?? [])),
            'internalPickupDamageImages' => array_map(function($internal_damage) {
                return asset($internal_damage['image'] ?? '');
            }, $internalPickupDamages ?? []),

            'warningTriangle' => $pickupOptions['triangle_reflector'] ?? 'no',
            'warningVest' => $pickupOptions['reflective_vest'] ?? 'no',
            'firstAidKit' => $pickupOptions['first_aid_kit'] ?? 'no',
            'returnCleanliness' => $pickupOptions['clean'] ?? 'no',
            'tireProfile' => $pickupOptions['tire_profile'] ?? 'no',
            
            'handoverDamage' => implode(', ', array_map(function($handoverDamage) {
                return $handoverDamage['description'] ?? '';
            }, $carJson['damages'] ?? [])),
            'handoverDamageImage' => array_map(function($handoverDamageImage) {
                return asset($handoverDamageImage['photo'] ?? '');
            }, $carJson['damages'] ?? []),

            'internalHandoverDamage' => implode(', ', array_map(function($internalHandoverDamage) {
                return $internalHandoverDamage['description'] ?? '';
            }, $carJson['damages'] ?? [])),
            'internalHandoverDamageImage' => array_map(function($internalHandoverDamageImage) {
                return asset($internalHandoverDamageImage['image'] ?? '');
            }, $carJson['internal_damages'] ?? []),

            'handoverWarningTriangle' => json_decode($carJson['options'] ?? '{}')->triangle_reflector ?? 'no',
            'handoverWarningVest' => json_decode($carJson['options'] ?? '{}')->reflective_vest ?? 'no',
            'handoverFirstAidKit' => json_decode($carJson['options'] ?? '{}')->first_aid_kit ?? 'no',
            'handoverCarCleanliness' => json_decode($carJson['options'] ?? '{}')->clean ?? 'no',
            'handoverTireProfile' => json_decode($carJson['options'] ?? '{}')->tire_profile ?? 'no',
            'deliverReportImage' => $this->contract->deliver_damages_image,
            'pickupReportImage' => $this->contract->pickup_damages_image,
        ]);
        // Mail'i oluştur
        $content = $this->generateContent();
        $pickupDamageDescriptions = [];
        $pickupDamageImages = [];
        
        // Her bir hasar için açıklama ve resim ekleme
        foreach ($pickupDamages as $damage) {
            $pickupDamageDescriptions[] = $damage['description'] ?? 'N/A';  // Açıklamayı ekle
            $pickupDamageImages[] = asset($damage['photo'] ?? '');  // Resmi ekle
        }
        return $this->subject($this->subject)->view('emails.contractPickup')
        ->with([
            'contract' => $this->contract,
            'insurancePackage' => json_decode($this->contract->insurance_packages, true),
            'kilometerPackage' => json_decode($this->contract->km_packages, true),
            'carModel' => ($carJson['car']['brand'] ?? 'N/A') . ' ' . ($carJson['car']['model'] ?? 'N/A'),
            'licensePlate' => $carJson['number_plate'] ?? 'N/A',
            'returnDate' => $this->contract->end_date,
            'returnTime' => Carbon::parse($this->contract->end_date)->format('H:i'),
            'returnDay' => Carbon::parse($this->contract->end_date)->diffInDays(Carbon::parse($this->contract->start_date)),
            
            'pickupDamage' => implode(', ', array_map(function($damage) {
                return $damage['description'] ?? 'w';
            }, $pickupDamages ?? [])),
            'pickupDamageImages' => array_map(function($damage) {
                return asset($damage['photo'] ?? 'w');
            }, $pickupDamages ?? []),
            'warningTriangle' => $pickupOptions['triangle_reflector'] ?? 'N/A',
            'warningVest' => $pickupOptions['reflective_vest'] ?? 'N/A',
            'firstAidKit' => $pickupOptions['first_aid_kit'] ?? 'N/A',
            'returnCleanliness' => $pickupOptions['clean'] ?? 'N/A',
            'tireProfile' => $pickupOptions['tire_profile'] ?? 'N/A',
            
            'handoverDamage' => implode(', ', array_map(function($handoverDamage) {
                return $handoverDamage['description'] ?? '';
            }, $carJson['damages'] ?? [])),
            'handoverDamageImage' => array_map(function($handoverDamageImage) {
                return asset($handoverDamageImage['photo'] ?? '');
            }, $carJson['damages'] ?? []),
            'handoverWarningTriangle' => json_decode($carJson['options'] ?? '{}')->triangle_reflector ?? 'N/A',
            'handoverWarningVest' => json_decode($carJson['options'] ?? '{}')->reflective_vest ?? 'N/A',
            'handoverFirstAidKit' => json_decode($carJson['options'] ?? '{}')->first_aid_kit ?? 'N/A',
            'handoverCarCleanliness' => json_decode($carJson['options'] ?? '{}')->clean ?? 'N/A',
            'handoverTireProfile' => json_decode($carJson['options'] ?? '{}')->tire_profile ?? 'N/A',
            'content' => $content,
            ])
            ->attach($pdf1Path, [
                'as' => 'disclaimer_de_1.pdf',
                'mime' => 'application/pdf',
                ])
                ->attach($pdf2Path, [
                    'as' => 'agb_de_1.pdf',
                    'mime' => 'application/pdf',
                    ])
                    ->attachData($pdf3->output(), 'contract-pickup.pdf', [
                        'mime' => 'application/pdf',
                    ]);
                }
                private function generateContent()
                {
                    // JSON verilerini dizilere dönüştür
                    $carJson = json_decode($this->contract->car, true);
                    $pickupOptions = json_decode($this->contract->options, true);
                    $pickupDamages = json_decode($this->contract->damages, true);
                    $handoverDamages = $carJson['damages'] ?? [];

                    $internalPickupDamages = json_decode($this->contract->internal_damages, true);
                    $internalHandoverDamages = $carJson['internal_damages'] ?? [];
                    $handoverOptions = json_decode($carJson['options'] ?? '{}', true);
                    
                    // Verileri yer tutucular için hazırlayın
                    $carModel = ($carJson['car']['brand'] ?? 'N/A') . ' ' . ($carJson['car']['model'] ?? 'N/A');
                    $licensePlate = $carJson['number_plate'] ?? 'N/A';
                    $returnDate = $this->contract->end_date;
                    $returnTime = Carbon::parse($this->contract->end_date)->format('H:i');
                    $returnDay = Carbon::parse($this->contract->end_date)->diffInDays(Carbon::parse($this->contract->start_date));
                    
                    $pickupDamage = implode(', ', array_map(function($damage) {
                        return $damage['description'] ?? 'N/A';
                    }, $pickupDamages));
                    
                    $pickupDamageImages = implode("\n", array_map(function($damage) {
                        // Resimlerin HTML img etiketine dönüştürülmesi
                        $imageSrc = asset($damage['photo'] ?? '');
                        return '<img src="' . $imageSrc . '" alt="Damage Image" style="width: 100px; height: auto;">'; // Resim boyutunu ayarlayın
                    }, $pickupDamages));

                    $internalPickupDamage = implode(', ', array_map(function($internal_damage) {
                        return $internal_damage['description'] ?? 'N/A';
                    }, $internalPickupDamages));
                    
                    $internalPickupDamageImages = implode("\n", array_map(function($internal_damage) {
                        // Resimlerin HTML img etiketine dönüştürülmesi
                        $imageSrc = asset($internal_damage['image'] ?? '');
                        return '<img src="' . $imageSrc . '" alt="Damage Image" style="width: 100px; height: auto;">'; // Resim boyutunu ayarlayın
                    }, $internalPickupDamages));
                    
                    $warningTriangle = $pickupOptions['triangle_reflector'] ?? 'N/A';
                    $warningVest = $pickupOptions['reflective_vest'] ?? 'N/A';
                    $firstAidKit = $pickupOptions['first_aid_kit'] ?? 'N/A';
                    $returnCleanliness = $pickupOptions['clean'] ?? 'N/A';
                    $tireProfile = $pickupOptions['tire_profile'] ?? 'N/A';
                    
                    $handoverDamage = implode(', ', array_map(function($damage) {
                        return $damage['description'] ?? 'N/A';
                    }, $handoverDamages));
                    
                    $handoverDamageImage = implode("\n", array_map(function($damage) {
                        // Handover hasar resimlerini HTML img etiketine dönüştürme
                        $imageSrc = asset($damage['photo'] ?? '');
                        return '<img src="' . $imageSrc . '" alt="Handover Innerer Damage Image" style="width: 100px; height: auto;">';
                    }, $handoverDamages));

                    $internalHandoverDamage = implode(', ', array_map(function($handover_damage) {
                        return $handover_damage['description'] ?? 'N/A';
                    }, $internalHandoverDamages));
                    
                    $internalHandoverDamageImage = implode("\n", array_map(function($handover_damage) {
                        // Handover hasar resimlerini HTML img etiketine dönüştürme
                        $imageSrc = asset($handover_damage['image'] ?? '');
                        return '<img src="' . $imageSrc . '" alt="Handover Innerer Damage Image" style="width: 100px; height: auto;">';
                    }, $internalHandoverDamages));
                    
                    $handoverWarningTriangle = $handoverOptions['triangle_reflector'] ?? 'N/A';
                    $handoverWarningVest = $handoverOptions['reflective_vest'] ?? 'N/A';
                    $handoverFirstAidKit = $handoverOptions['first_aid_kit'] ?? 'N/A';
                    $handoverCarCleanliness = $handoverOptions['clean'] ?? 'N/A';
                    $handoverTireProfile = $handoverOptions['tire_profile'] ?? 'N/A';
                    
                    // Kilometre ve sigorta paketlerini ayırın
                    $kilometerPackage = json_decode($this->contract->kilometer_package ?? '{}', true);
                    $insurancePackage = json_decode($this->contract->insurance_package ?? '{}', true);
                    
                    // Fiyat hesaplamaları
                    $kilometerPrice = (intval($kilometerPackage['kilometer'] ?? 0) * floatval($kilometerPackage['extra_price'] ?? 0));
                    $insurancePrice = (floatval($insurancePackage['price_per_day'] ?? 0) * intval($returnDay ?? 1));
                    $carSubtotalPrice = floatval($this->contract->car_subtotal_price ?? 0);
                    $subTotalPrice = $carSubtotalPrice + $insurancePrice + $kilometerPrice;
                    $tax = $subTotalPrice * 0.19;
                    $totalPrice = $subTotalPrice + $tax;
                    
                    // İçerik şablonunu yer tutucularla değiştirin
                    $placeholders = [
                        '{{ $carModel }}',
                        '{{ $licensePlate }}',
                        '{{ $returnDate }}',
                        '{{ $returnTime }}',
                        '{{ $returnDay }}',
                        '{{ $pickupDamage }}',
                        '{{ $pickupDamageImages }}',
                        '{{ $warningTriangle }}',
                        '{{ $warningVest }}',
                        '{{ $firstAidKit }}',
                        '{{ $returnCleanliness }}',
                        '{{ $tireProfile }}',
                        '{{ $handoverDamage }}',
                        '{{ $handoverDamageImage }}',
                        '{{ $handoverWarningTriangle }}',
                        '{{ $handoverWarningVest }}',
                        '{{ $handoverFirstAidKit }}',
                        '{{ $handoverCarCleanliness }}',
                        '{{ $handoverTireProfile }}',
                        '{{ $carSubtotalPrice }}',
                        '{{ $returnDay }}',
                        '{{ $kilometerPrice }}',
                        '{{ $insurancePrice }}',
                        '{{ $subTotalPrice }}',
                        '{{ $tax }}',
                        '{{ $totalPrice }}',
                        '{{ $kilometerPackageDetails }}',
                        '{{ $insurancePackageDetails }}',
                        '{{ $internalHandoverDamage }}',
                        '{{ $internalHandoverDamageImage }}',
                        '{{ $internalPickupDamage }}',
                        '{{ $internalPickupDamageImages }}',
                    ];
                    
                    $replacements = [
                        $carModel,
                        $licensePlate,
                        $returnDate,
                        $returnTime,
                        $returnDay,
                        $pickupDamage,
                        $pickupDamageImages,
                        $warningTriangle,
                        $warningVest,
                        $firstAidKit,
                        $returnCleanliness,
                        $tireProfile,
                        $handoverDamage,
                        $handoverDamageImage,
                        $handoverWarningTriangle,
                        $handoverWarningVest,
                        $handoverFirstAidKit,
                        $handoverCarCleanliness,
                        $handoverTireProfile,
                        number_format($carSubtotalPrice, 2),
                        $returnDay,
                        number_format($kilometerPrice, 2),
                        number_format($insurancePrice, 2),
                        number_format($subTotalPrice, 2),
                        number_format($tax, 2),
                        number_format($totalPrice, 2),
                        $kilometerPackage['details'] ?? 'N/A',
                        $insurancePackage['details'] ?? 'N/A',
                        $internalHandoverDamage,
                        $internalHandoverDamageImage,
                        $internalPickupDamage,
                        $internalPickupDamageImages,
                    ];
                    
                    $content = $this->contractMailTemplate; // mailTemplate burada e-posta içeriği olarak ayarlanmalıdır
                    return str_replace($placeholders, $replacements, $content);
                }
            }
            