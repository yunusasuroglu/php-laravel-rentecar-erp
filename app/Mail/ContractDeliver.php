<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class ContractDeliver extends Mailable
{
    use Queueable, SerializesModels;

    protected $contract;
    public $subject;
    public $contractMailTemplate;

    /**
     * Create a new message instance.
     *
     * @param  $contract
     * @param  $subject
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
        // JSON verilerini çözümleyin
        $carJson = json_decode($this->contract->car, true);

        // PDF dosyalarının yollarını belirleyin
        $todayDate = now()->format('d.m.Y'); 
        $pdf1Path = storage_path('app/public/pdfs/disclaimer_de_1.pdf');
        $pdf2Path = storage_path('app/public/pdfs/agb_de_1.pdf');

        // Dinamik içerik oluşturma
        $content = $this->generateContent($carJson);

        // PDF3 oluşturma
        $pdf3 = PDF::loadView('pdf.contractDeliver', [
            'contract' => $this->contract,
            'carModel' => ($carJson['car']['brand'] ?? 'N/A') . ' ' . ($carJson['car']['model'] ?? 'N/A'),
            'licensePlate' => $carJson['number_plate'] ?? 'N/A',
            'returnDate' => $this->contract->end_date,
            'damages' => $carJson['damages'] ?? [],
            'damageImages' => array_map(function($damage) {
                return asset($damage['photo'] ?? '');
            }, $carJson['damages'] ?? []),
            'warningTriangle' => json_decode($carJson['options'] ?? '{}')->triangle_reflector ?? 'N/A',
            'warningVest' => json_decode($carJson['options'] ?? '{}')->reflective_vest ?? 'N/A',
            'firstAidKit' => json_decode($carJson['options'] ?? '{}')->first_aid_kit ?? 'N/A',
            'carCleanliness' => json_decode($carJson['options'] ?? '{}')->clean ?? 'N/A',
            'tireTread' => json_decode($carJson['options'] ?? '{}')->tire_profile ?? 'N/A',
            'todayDate' => $todayDate,
        ]);

        // Mail'i oluştur
        return $this->subject($this->subject)
            ->view('emails.contractDeliver')
            ->with([
                'carModel' => ($carJson['car']['brand'] ?? 'N/A') . ' ' . ($carJson['car']['model'] ?? 'N/A'),
                'licensePlate' => $carJson['number_plate'] ?? 'N/A',
                'returnDate' => $this->contract->end_date,
                'damages' => $carJson['damages'] ?? [],
                'damageImages' => array_map(function($damage) {
                    return asset($damage['photo'] ?? '');
                }, $carJson['damages'] ?? []),
                'warningTriangle' => json_decode($carJson['options'] ?? '{}')->triangle_reflector ?? 'N/A',
                'warningVest' => json_decode($carJson['options'] ?? '{}')->reflective_vest ?? 'N/A',
                'firstAidKit' => json_decode($carJson['options'] ?? '{}')->first_aid_kit ?? 'N/A',
                'carCleanliness' => json_decode($carJson['options'] ?? '{}')->clean ?? 'N/A',
                'tireTread' => json_decode($carJson['options'] ?? '{}')->tire_profile ?? 'N/A',
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
            ->attachData($pdf3->output(), 'contract-handover.pdf', [
                'mime' => 'application/pdf',
            ]);
    }

    /**
     * Generate dynamic content for the email.
     *
     * @param  array  $carJson
     * @return string
     */
    private function generateContent($carJson)
{
    $carModel = ($carJson['car']['brand'] ?? 'N/A') . ' ' . ($carJson['car']['model'] ?? 'N/A');
    $carPlate = $carJson['number_plate'] ?? 'N/A';
    $returnDate = $this->contract->end_date;
    $damages = $carJson['damages'] ?? [];
    $damageImages = array_map(function($damage) {
        return asset($damage['photo'] ?? '');
    }, $damages);
    
    // JSON içindeki options alanını çözümleyin
    $options = json_decode($carJson['options'] ?? '{}', true);
    $warningTriangle = $options['triangle_reflector'] ?? 'N/A';
    $warningVest = $options['reflective_vest'] ?? 'N/A';
    $firstAidKit = $options['first_aid_kit'] ?? 'N/A';
    $carCleanliness = $options['clean'] ?? 'N/A';
    $tireTread = $options['tire_profile'] ?? 'N/A';
    
    // İçerikteki yer tutucular ve değerler
    $placeholders = [
        '{{ $carModel }}',
        '{{ $licensePlate }}',
        '{{ $returnDate }}',
        '{{ $damage["description"] }}',
        '{{ $image }}',
        '{{ $warningTriangle }}',
        '{{ $warningVest }}',
        '{{ $firstAidKit }}',
        '{{ $carCleanliness }}',
        '{{ $tireTread }}'
    ];

    // Yer tutucuların karşılıkları
    $damagesDescriptions = implode("\n", array_map(function($damage) {
        return $damage['description'] ?? 'N/A';
    }, $damages));

    $damageImagesContent = implode("\n", array_map(function($image) {
        return '<img src="' . $image . '" alt="Damage Image" style="max-width: 200px; max-height: 200px;"/>';
    }, $damageImages));

    $replacements = [
        $carModel,
        $carPlate,
        $returnDate,
        $damagesDescriptions,
        $damageImagesContent,
        $warningTriangle,
        $warningVest,
        $firstAidKit,
        $carCleanliness,
        $tireTread
    ];

    // E-posta içeriğini al
    $content = $this->contractMailTemplate; // mailTemplate burada e-posta içeriği olarak ayarlanmalıdır

    // Yer tutucuları değiştir
    $content = str_replace($placeholders, $replacements, $content);

    return $content;
}
}