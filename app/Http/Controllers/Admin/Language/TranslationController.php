<?php

namespace App\Http\Controllers\Admin\Language;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Translation;
use App\Models\TranslationKey;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function index(Request $request, $code)
    {
        $language = Language::where('code', $code)->firstOrFail();
        $translations = Translation::where('language_id', $language->id)->get(); // Sayfa başına 4 kayıt göster
        return view('superadmin.languages.translations.translations', compact('translations', 'language'));
    }


    public function update(Request $request, $code)
    {
        // Dil koduna göre dili bulun
        $language = Language::where('code', $code)->firstOrFail();

        // Gönderilen çeviri verilerini işleyin
        $data = $request->all();

        // Her bir çeviri anahtarı için güncelleme yapın
        foreach ($data['translations'] as $key => $value) {
            $translation = Translation::where('language_id', $language->id)->where('key', $key)->first();
            if ($translation) {
                $translation->update(['value' => $value]);
            }
        }

        return redirect()->route('languages.translations', $code)->with('success', 'Translations updated successfully.');
    }
}
