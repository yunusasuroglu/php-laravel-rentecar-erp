<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use PDF;
use Illuminate\Queue\SerializesModels;

class InvoiceCreated extends Mailable
{
    use Queueable, SerializesModels;
    
    public $invoice;
    public $subject;
    public $contractMailTemplate;
    
    /**
    * Create a new message instance.
    *
    * @return void
    */
    public function __construct($invoice, $subject, $contractMailTemplate)
    {
        $this->invoice = $invoice;
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
        $pdf3 = PDF::loadView('pdf.invoice-pdf', ['invoice' => $this->invoice,]);
        $content = $this->generateContent();
        return $this->subject($this->subject)->view('emails.invoiceCreated')
        ->with([
            'invoice' => $this->invoice,
            'content' => $content,
            ])->attachData($pdf3->output(), 'invoice.pdf', [
                'mime' => 'application/pdf',
            ]);
        }
        private function generateContent()
        {
            // JSON verilerini al
            $items = json_decode($this->invoice->items, true);
            $authorCompany = json_decode($this->invoice->author_company, true);
        
            // Placeholders ve replacements dizilerini tanımla
            $placeholders = [
                '{{author_company_name}}',
                '{{author_company_city}}',
                '{{author_company_country}}',
                '{{author_company_zip_code}}',
                '{{author_company_phone}}',
                '{{author_company_fax}}',
                '{{author_company_email}}',
                '{{author_company_iban}}',
                '{{author_company_bic}}',
                '{{customer_name}}',
                '{{customer_street}}',
                '{{customer_zip_code}}',
                '{{customer_city}}',
                '{{customer_country}}',
                '{{customer_phone}}',
                '{{customer_email}}',
                '{{invoice_id}}',
                '{{invoice_totalprice_without_tax}}',
                '{{invoice_tax}}',
                '{{invoice_totalprice}}',
                '{{reverse_charge_text}}',
                '{{invoice_due_date}}',
                '{{google_review_link}}',
                '{{author_company_address}}',
                '{{author_company_street}}',
                '{{author_company_street}}',
                '{{author_company_zip_code}}',
                '{{author_company_city}}',
                '{{author_company_stnr}}',
                '{{author_company_ust_id_nr}}',
                '{{author_company_hrb}}',
                '{{author_company_registry_court}}',
                '{{author_company_general_manager}}',
                '{{items_details}}'
            ];
            $itemsDetails = '';
            foreach ($items as $item) {
                $itemsDetails .= (isset($item['name']) ? $item['name'] : 'N/A') . ', ' .
                                 (isset($item['description']) ? $item['description'] : 'N/A') . '<br>';
            }
            $replacements = [
                $authorCompany['name'] ?? 'N/A',
                $authorCompany['city'] ?? 'N/A',
                $authorCompany['country'] ?? 'N/A',
                $authorCompany['zip_code'] ?? 'N/A',
                $authorCompany['phone'] ?? 'N/A',
                $authorCompany['fax'] ?? 'N/A',
                $authorCompany['email'] ?? 'N/A',
                $authorCompany['iban'] ?? 'N/A',
                $authorCompany['bic'] ?? 'N/A',
                $this->invoice->customer['name'] ?? 'N/A',
                $this->invoice->customer['street'] ?? 'N/A',
                $this->invoice->customer['zip_code'] ?? 'N/A',
                $this->invoice->customer['city'] ?? 'N/A',
                $this->invoice->customer['country'] ?? 'N/A',
                $this->invoice->customer['phone'] ?? 'N/A',
                $this->invoice->customer['email'] ?? 'N/A',
                $this->invoice->id,
                $this->invoice->totalprice - $this->invoice->tax,
                $this->invoice->tax,
                $this->invoice->totalprice,
                '*Steuerschuldnerschaft des Leistungsempfängers (Reverse Charge)',
                $this->invoice->created_at->addDays(7)->format('d.m.Y'),
                $authorCompany['name'] ?? 'N/A', // Google review link or placeholder
                $authorCompany['street'] ?? 'N/A',
                $authorCompany['street'] ?? 'N/A',
                $authorCompany['zip_code'] ?? 'N/A',
                $authorCompany['city'] ?? 'N/A',
                $authorCompany['stnr'] ?? 'N/A',
                $authorCompany['ust_id_nr'] ?? 'N/A',
                $authorCompany['hrb'] ?? 'N/A',
                $authorCompany['registry_court'] ?? 'N/A',
                $authorCompany['general_manager'] ?? 'N/A',
                $itemsDetails 
            ];
        
            // İçeriği yer tutucularla değiştir
            $content = $this->contractMailTemplate; // mailTemplate burada e-posta içeriği olarak ayarlanmalıdır
            return str_replace($placeholders, $replacements, $content);
        }
        
    }