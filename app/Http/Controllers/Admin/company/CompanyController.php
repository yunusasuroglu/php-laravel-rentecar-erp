<?php

namespace App\Http\Controllers\Admin\company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function companies()
    {
        $companies = Company::all();
        return view('superadmin.companies.companies', compact('companies'));
    }
    public function NewCompany()
    {
        return view('superadmin.companies.new-company');
    }
    public function AddCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $address = [
            'country' => $request->input('country'),
            'city' => $request->input('city'),
            'street' => $request->input('street'),
            'zip_code' => $request->input('zip_code'),
        ];
        
        $company = new Company([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'fax' => $request->input('fax'),
            'hrb' => $request->input('hrb'),
            'iban' => $request->input('iban'),
            'bic' => $request->input('bic'),
            'stnr' => $request->input('stnr'),
            'ust_id_nr' => $request->input('ust_id_nr'),
            'registry_court' => $request->input('registry_court'),
            'general_manager' => $request->input('general_manager'),
            'address' => json_encode($address),
            'status' => 1,
            'reference_token' => Str::uuid()->toString(),
        ]);
        
        // Yeni şirket nesnesini veritabanına kaydedin
        $company->save();
        
        return redirect()->route('companies')->with('success', 'Şirket başarıyla oluşturuldu.');
    }
    public function EditCompany($id)
    {
        // Düzenlenmek istenen şirketi bulun
        $company = Company::findOrFail($id);
        
        // Şirketin adresini JSON'dan diziye çözümle
        $address = json_decode($company->address, true);
        
        // Şirket ve adres bilgilerini view'a gönder
        return view('superadmin.companies.edit-company', compact('company', 'address'));
    }
    public function UpdateCompany(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'fax' => 'nullable|string|max:255',
            'hrb' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:255',
            'bic' => 'nullable|string|max:255',
            'stnr' => 'nullable|string|max:255',
            'ust_id_nr' => 'nullable|string|max:255',
            'registry_court' => 'nullable|string|max:255',
            'general_manager' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:255',
        ]);
        
        $company = Company::findOrFail($id);
        
        $address = [
            'country' => $request->input('country'),
            'city' => $request->input('city'),
            'street' => $request->input('street'),
            'zip_code' => $request->input('zip_code'),
        ];
        
        $company->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'fax' => $request->input('fax'),
            'hrb' => $request->input('hrb'),
            'iban' => $request->input('iban'),
            'bic' => $request->input('bic'),
            'stnr' => $request->input('stnr'),
            'ust_id_nr' => $request->input('ust_id_nr'),
            'registry_court' => $request->input('registry_court'),
            'general_manager' => $request->input('general_manager'),
            'address' => json_encode($address),
        ]);
        
        return redirect()->route('companies')->with('success', 'Şirket başarıyla güncellendi.');
    }
    public function destroy($id)
    {
        // Şirketi bulun
        $company = Company::findOrFail($id);
        
        // Şirketi sil
        $company->delete();
        
        // Başarılı mesajıyla yönlendirin
        return redirect()->route('companies')->with('success', 'Şirket başarıyla silindi.');
    }
    public function approveCompany($id)
    {
        $user = Company::find($id);
        
        $user->status = 1;
        $user->save();
        return redirect()->back()->with('success', 'Şirket Başarı ile Onaylandı');
        
    }
}
