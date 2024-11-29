<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use PDF;
use Illuminate\Queue\SerializesModels;

class ContractCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $contract;
    public $subject; 
    public $mailTemplate;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contract, $subject, $mailTemplate)
    {
        $this->contract = $contract;
        $this->subject = $subject;
        $this->mailTemplate = $mailTemplate;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $carData = json_decode($this->contract->car, true);
        $customer = json_decode($this->contract->customer, true);
        // Örnek içerik, gerçek mail template içeriği ile değiştirilmeli
        $content = $this->mailTemplate;
    
        $placeholders = [
            '{{ $contract->id }}', 
            '{{ $customer["name"] }}', 
            '{{ $customer["surname"] }}', 
            '{{ $contract->start_date }}', 
            '{{ $contract->end_date }}',
            '{{ $carData["car"]["brand"] }}',
            '{{ $carData["car"]["model"] }}',
            '{{ $carData["number_plate"] }}',
            '{{ $contract->total_amount }}'
        ];
    
        $replacements = [
            $this->contract->id,
            $customer['name'],
            $customer['surname'],
            $this->contract->start_date,
            $this->contract->end_date,
            $carData['car']['brand'],
            $carData['car']['model'],
            $carData['number_plate'],
            $this->contract->total_amount
        ];
    
        $content = str_replace($placeholders, $replacements, $content);
        // Önceden oluşturulmuş PDF dosyalarının yollarını belirleyin
        $pdf1Path = storage_path('app/public/pdfs/disclaimer_de_1.pdf');
        $pdf2Path = storage_path('app/public/pdfs/agb_de_1.pdf');
        $pdf3 = PDF::loadView('pdf.contractAdd', ['contract' => $this->contract]);

        // Mail'i oluştur
        return $this->subject($this->subject) // Dinamik olarak başlığı ayarlıyoruz
        ->view('emails.contractCreated')
        ->with([
            'contract' => $this->contract,
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
        ->attachData($pdf3->output(), 'contract.pdf', [
            'mime' => 'application/pdf',
        ]);
}
}
