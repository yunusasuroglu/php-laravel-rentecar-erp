<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use PDF;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceResendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice, $subject)
    {
        $this->invoice = $invoice;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf3 = PDF::loadView('pdf.invoice-pdf', ['invoice' => $this->invoice,]);
        return $this->subject($this->subject)->view('emails.invoiceCreated')
            ->with([
                'invoice' => $this->invoice,
            ])->attachData($pdf3->output(), 'invoice.pdf', [
            'mime' => 'application/pdf',
        ]);
    }
}
