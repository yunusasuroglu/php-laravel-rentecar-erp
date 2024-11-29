<?php

namespace App\Http\Controllers\Company\invoices;

use App\Http\Controllers\Controller;
use App\Mail\invoiceCreated;
use App\Mail\InvoiceResendMail;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Setting;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;
use PhpParser\JsonDecoder;

class InvoiceController extends Controller
{
    public function Invoices()
    {
        $companyId = auth()->user()->company_id;

        $invoices = Invoice::where('company_id', $companyId)->get();

        return view('company.invoices.invoices', compact('invoices'));
    }
    public function InvoiceAdd($id)
    {
        // Sözleşmeyi ID ile çek
        $contract = Contract::find($id);
        // Sözleşmenin var olup olmadığını kontrol et
        if (!$contract) {
            return redirect()->back()->with('error', 'Sözleşme bulunamadı.');
        }
        if (is_string($contract->customer)) {
            $customer = json_decode($contract->customer, true); // JSON string ise diziye çevir
        } else {
            // Zaten bir dizi ise, doğrudan kullan
            $customer = $contract->customer;
        }
        $customerId = $contract->customer_id;
        $car = json_decode($contract->car, true);
        // Sözleşmeyi "invoices" görünümüne gönder
        return view('company.invoices.invoice-add', compact('contract','customerId','customer','car'));
    }
    public function addInvoice(Request $request)
    {
        $companyId = auth()->user()->company_id;
        // Form verilerini doğrulama
        $validatedData = $request;
        $id = $validatedData['contract_id'];
        $contract = Contract::find($id);
        $authorCompany = auth()->user()->company;
        $aCompanyAddress = json_decode($authorCompany->address, true);
        $items = $request->input('items', []);
        // Fatura verilerini oluşturma
        $invoice = new Invoice();
        $invoice->items = json_encode($items);        
        $invoice->customer = [
            'id' => $contract->customer_id,
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'zip_code' => $validatedData['zip_code'],
            'city' => $validatedData['city'],
            'email' => $validatedData['email'],
        ];
        $invoice->customer_id = $contract->customer_id;
        $invoice->discount = $validatedData['discount'] ?? 0;
        $invoice->note = $validatedData['note'] ?? '';
        $invoice->start_date = $contract->start_date;
        $invoice->end_date = $contract->end_date;


        // Subtotal ve Tax hesaplama (örnek olarak)
        $invoice->subtotalprice = $validatedData['subtotal'];
        $invoice->tax = $validatedData['tax'];
        $invoice->totalprice = $validatedData['totalprice'];
        $invoice->company_id = $companyId;
        $invoice->contract_id = $id;
        $invoice->payment_option = $contract->payment_option;
        if($contract->payment_option == 'Invoice'){
            $invoice->payment_status = 3;
        }elseif($contract->payment_option == 'Cash'){
            $invoice->payment_status = 2;
        }

        $companyInfo = [
            'name' => $authorCompany->name ?? '',
            'phone' => $authorCompany->phone ?? '',
            'tax_number' => $authorCompany->tax_number ?? '',
            'logo' => $authorCompany->logo ?? '',
            'fax' => $authorCompany->fax ?? '',
            'hrb' => $authorCompany->hrb ?? '',
            'iban' => $authorCompany->iban ?? '',
            'bic' => $authorCompany->bic ?? '',
            'stnr' => $authorCompany->stnr ?? '',
            'ust_id_nr' => $authorCompany->ust_id_nr ?? '',
            'registry_court' => $authorCompany->registry_court ?? '',
            'general_manager' => $authorCompany->general_manager ?? '',
            'email' => $authorCompany->email ?? '',
            'street' => $aCompanyAddress['street'] ?? '',
            'zip_code' => $aCompanyAddress['zip_code'] ?? '',
            'city' => $aCompanyAddress['city'] ?? '',
            'country' => $aCompanyAddress['country'] ?? '',
        ];
        $invoice->author_company = json_encode($companyInfo, true);

        $invoice->save();

        $contract->status = 6;
        $contract->save();
        if (is_string($contract->customer)) {
            $customerData = json_decode($contract->customer, true); // JSON string ise diziye çevir
        } else {
            // Zaten bir dizi ise, doğrudan kullan
            $customerData = $contract->customer;
        }
        
        $customerEmail = $customerData['email'];
        $customerName = $customerData['name'];
        $companyName = $authorCompany->name;  // İlişki ile company bilgisi alınır
        $subject = $companyName . ' - Invoice for ' . $customerName;
        $contractMailTemplate = Setting::where('key', 'invoice_mail')->value('value');

        Mail::to($customerEmail)->send(new invoiceCreated($invoice, $subject, $contractMailTemplate));
        return redirect()->route('invoices')->with('success', 'The invoice has been successfully saved and sent.');
    }
    public function InvoiceShow($id)
    {
        // Şirkete bağlı faturayı çekmek için mevcut kullanıcının şirkete bağlı olduğunu doğrulayın
        $companyId = Auth::user()->company_id;

        // Faturayı sorgulayın
        $invoice = Invoice::where('id', $id)->where('company_id', $companyId)->firstOrFail();

        $invoiceJson = json_decode($invoice, true);
        $items = json_decode($invoice->items, true);
        // dd($invoiceJson);
        $company = Auth::user()->company;
        // Faturayı görünüm ile paylaş
        return view('company.invoices.invoice-show', compact('invoice','invoiceJson','company','items'));
    }
    public function PaymentInvoice(Invoice $invoice)
    {
        $invoice->payment_status = 1;
    
        $invoice->save();
    
        return redirect()->route('invoices')->with('success', 'Invoice payment status has been successfully updated.');
    }
    public function CancelledInvoice(Invoice $invoice)
    {
        $invoice->status = 2;
    
        $invoice->save();
    
        return redirect()->route('invoices')->with('success', 'Invoice payment status has been successfully updated.');
    }
    public function ApprovedInvoice(Invoice $invoice)
    {
        $invoice->payment_status = 1;
    
        $invoice->save();
    
        return redirect()->route('invoices')->with('success', 'Invoice Approved');
    }
    public function resendInvoice(Invoice $invoice)
    {
        if (is_string($invoice->customer)) {
            $customerData = json_decode($invoice->customer, true); // JSON string ise diziye çevir
        } else {
            // Zaten bir dizi ise, doğrudan kullan
            $customerData = $invoice->customer;
        }
        $authorCompany = auth()->user()->company;
        $customerEmail = $customerData['email'];
        $customerName = $customerData['name'];
        $companyName = $authorCompany->name;  // İlişki ile company bilgisi alınır
        
        $subject = $companyName . ' - Invoice for ' . $customerName;
        Mail::to($customerEmail)->send(new invoiceCreated($invoice, $subject));
        
        return redirect()->back();
    }
    public function downloadInvoice($id){
        $companyId = Auth::user()->company_id;

        $invoice = Invoice::where('id', $id)->where('company_id', $companyId)->firstOrFail();

        $invoiceJson = json_decode($invoice, true);
        $items = json_decode($invoice->items, true);
        $company = Auth::user()->company;

        $pdf = PDF::loadView('pdf.invoice-pdf', compact('invoice','invoiceJson','company','items'));
        return $pdf->download('invoice.pdf');
    }

    public function ManuelInvoice()
    {
        // Giriş yapmış kullanıcının şirketine ait company_id'yi al
        $companyId = auth()->user()->company_id;
    
        // Şirketi ID ile çek
        $company = Company::find($companyId);
    
        // Şirkete ait müşterileri al
        $customers = $company ? $company->customers : collect();  // Eğer şirket varsa müşterileri al, yoksa boş bir koleksiyon döndür
    
        // View'e verileri gönder
        return view('company.invoices.invoice-manuel-add', compact('customers'));
    }

    public function ManuelInvoiceAdd(Request $request)
    {
        $companyId = auth()->user()->company_id;
        // Form verilerini doğrulama
        $validatedData = $request;
        $authorCompany = auth()->user()->company;
        $aCompanyAddress = json_decode($authorCompany->address, true);
        $items = $request->input('items', []);
        // Fatura verilerini oluşturma
        $invoice = new Invoice();
        $invoice->items = json_encode($items);        
        $invoice->customer = [
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'zip_code' => $validatedData['zip_code'],
            'city' => $validatedData['city'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
        ];
        $invoice->discount = $validatedData['discount'] ?? 0;
        $invoice->note = $validatedData['note'] ?? '';


        // Subtotal ve Tax hesaplama (örnek olarak)
        $invoice->subtotalprice = $validatedData['subtotal'];
        $invoice->tax = $validatedData['tax'];
        $invoice->totalprice = $validatedData['totalprice'];
        $invoice->company_id = $companyId;
        $invoice->payment_option = "Manuel Invoice";
        $invoice->payment_status = 1;

        $companyInfo = [
            'name' => $authorCompany->name ?? '',
            'phone' => $authorCompany->phone ?? '',
            'tax_number' => $authorCompany->tax_number ?? '',
            'logo' => $authorCompany->logo ?? '',
            'fax' => $authorCompany->fax ?? '',
            'hrb' => $authorCompany->hrb ?? '',
            'iban' => $authorCompany->iban ?? '',
            'bic' => $authorCompany->bic ?? '',
            'stnr' => $authorCompany->stnr ?? '',
            'ust_id_nr' => $authorCompany->ust_id_nr ?? '',
            'registry_court' => $authorCompany->registry_court ?? '',
            'general_manager' => $authorCompany->general_manager ?? '',
            'email' => $authorCompany->email ?? '',
            'street' => $aCompanyAddress['street'] ?? '',
            'zip_code' => $aCompanyAddress['zip_code'] ?? '',
            'city' => $aCompanyAddress['city'] ?? '',
            'country' => $aCompanyAddress['country'] ?? '',
        ];
        $invoice->author_company = json_encode($companyInfo, true);

        $invoice->save();
        
        $customerEmail = $validatedData['email'];
        $customerName = $validatedData['name'];
        $companyName = $authorCompany->name;  // İlişki ile company bilgisi alınır
        $subject = $companyName . ' - Invoice for ' . $customerName;
        $contractMailTemplate = Setting::where('key', 'invoice_mail')->value('value');

        Mail::to($customerEmail)->send(new invoiceCreated($invoice, $subject, $contractMailTemplate));
        return redirect()->route('invoices')->with('success', 'The invoice has been successfully saved and sent.');
    }
}
