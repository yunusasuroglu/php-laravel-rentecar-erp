<?php

namespace App\Mail;

use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use PDF;
use Illuminate\Queue\SerializesModels;

class ContractResendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contract;
    public $subject; 

    public function __construct(Contract $contract, $subject)
    {
        $this->contract = $contract;
        $this->subject = $subject;
    }

    public function build()
    {
        // Önceden oluşturulmuş PDF dosyalarının yollarını belirleyin
        $pdf1Path = storage_path('app/public/pdfs/disclaimer_de_1.pdf');
        $pdf2Path = storage_path('app/public/pdfs/agb_de_1.pdf');
        $pdf3 = PDF::loadView('pdf.contractAdd', ['contract' => $this->contract]);


        return $this->subject($this->subject)
        ->view('emails.contractResend')
        ->with([
            'contract' => $this->contract,
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
