<?php

namespace App\Http\Controllers\Admin\Language;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function languages()
    {
        $languages = Language::all();
        return view('superadmin.languages.languages', compact('languages'));
    }
    
    public function LanguageNew()
    {
        return view('superadmin.languages.new-language');
    }
    
    public function LanguageStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:languages',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Örnek geçerlilik kuralları, dosya türüne ve boyutuna göre ayarlanabilirsiniz
        ]);
        
        // Logo dosyasını işle
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $fileName = time() . '-' . $this->cleanFileName($logo->getClientOriginalName()); // Dosya adını oluştur
            $filePath = 'assets/images/country-logos/' . $fileName; // Dosya yolu
            
            // Dosyayı belirtilen yola kaydet
            $logo->move(public_path('assets/images/country-logos'), $fileName);
        } else {
            $filePath = null; // Varsayılan logo ayarlamak için null veya başka bir şey ekleyebilirsiniz
        }
        
        // Dil oluşturma işlemi
        $language = Language::create([
            'name' => $request->name,
            'code' => $request->code,
            'logo' => $filePath, // Logo dosya yolunu veritabanına kaydet
        ]);
        
        return redirect()->route('languages');
    }
    
    public function LanguageEdit(Language $language)
    {
        return view('superadmin.languages.edit-language', compact('language'));
    }
    
    public function LanguageUpdate(Request $request, Language $language)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:languages,code,' . $language->id,
        ]);
        
        $language->update($request->all());
        
        return redirect()->route('languages');
    }
    
    public function LanguageDestroy(Language $language)
    {
        $language->delete();
        return redirect()->route('languages');
    }
    public function switchLang($lang)
    {
        if (Language::where('code', $lang)->exists()) {
            Session::put('applocale', $lang);
        }
        return redirect()->back();
    }
    private function cleanFileName($fileName) {
        // Türkçe karakterleri değiştir
        $fileName = str_replace(['ç', 'ğ', 'ı', 'ö', 'ş', 'ü', 'Ç', 'Ğ', 'İ', 'Ö', 'Ş', 'Ü'], ['c', 'g', 'i', 'o', 's', 'u', 'c', 'g', 'i', 'o', 's', 'u'], $fileName);
        
        // Özel karakterleri ve boşlukları alt çizgi ile değiştir
        $fileName = preg_replace('/[^A-Za-z0-9_\-.]/', '-', $fileName);
        
        // Dosya adındaki büyük harfleri küçük harfe çevir
        $fileName = strtolower($fileName);
        
        return $fileName;
    }
}
