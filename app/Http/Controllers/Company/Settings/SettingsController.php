<?php

namespace App\Http\Controllers\Company\Settings;

use App\Http\Controllers\Controller; // Bu satırı eklemeyi unutmayın
use App\Models\Company;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    
    
    public function MailSetting($id)
    {
        $company = Company::where('id', $id)->first();
        // Veriyi al ve JSON olarak işle
        $settings = Setting::all()->keyBy('key')->map(function ($setting) {
            return $setting->value; // JSON verisini dizi olarak döndür
        });
        
        // Eğer tüm veriyi bir araya toplamak istiyorsanız
        $settingsData = $settings->toArray();
        // dd($settings);
        return view('management.mail-settings', compact('company','settingsData'));
    }
    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
