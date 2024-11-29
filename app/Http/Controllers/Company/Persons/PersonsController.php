<?php

namespace App\Http\Controllers\Company\Persons;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class PersonsController extends Controller
{
    public function Persons()
    {
        // Giriş yapan kullanıcıyı alalım
        $user = Auth::user();
        
        // Eğer kullanıcı mevcutsa, o kullanıcının ait olduğu şirketin personellerini alalım
        if ($user) {
            // Kullanıcının ait olduğu şirketin ID'sini alalım
            $companyId = $user->company_id;
            
            // Şirkete bağlı çalışanları alalım
            $person = User::where('company_id', $companyId)->with('roles')->get();
            
            return view('company.persons.persons', compact('person'));
        }
        
        return redirect()->route('login');
    }
    public function NewPerson()
    {
        $rol = Role::whereNotIn('id', [1, 2])->get();
        return view('company.persons.new-person', compact('rol'));
    }
    public function AddPerson(Request $request)
    {
        // Girişleri doğrula
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required', // Rol alanının zorunlu olduğunu doğrulayın
        ]);
        
        // Adres verilerini al
        $address = [
            'country' => $request->input('country'),
            'city' => $request->input('city'),
            'street' => $request->input('street'),
            'zip_code' => $request->input('zip_code'),
            'address' => $request->input('address'),
        ];
        
        // İmza verisini al ve kaydet
        $signatureData = $request->input('signature');
        
        // İmza verisinin formatını kontrol et
        if (strpos($signatureData, 'base64,') !== false) {
            $imageData = explode('base64,', $signatureData)[1];
            $imageData = base64_decode($imageData);
            
            if ($imageData === false) {
                return redirect()->back()->withErrors(['signature' => 'Geçersiz imza verisi.']);
            }
        } else {
            return redirect()->back()->withErrors(['signature' => 'Geçersiz imza formatı.']);
        }
        
        $fileName = 'signature_' . time() . '.png';
        $directory = public_path('assets/images/signatures');
        
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        $filePath = $directory . '/' . $fileName;
        file_put_contents($filePath, $imageData);
        $signaturePath = 'assets/images/signatures/' . $fileName;
        
        // Kullanıcı verisini oluştur
        $person = new User([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'signature' => $signaturePath, // İmza dosya yolunu kaydet
            'password' => Hash::make($request->input('password')),
            'address' => json_encode($address),
        ]);
        
        // Kullanıcı eklendiğinde, oturum açmış olan kullanıcının company_id'sini alarak atama yapın
        $user = Auth::user();
        $person->company_id = $user->company_id;
        $person->save();
        
        // Kullanıcıya rol atayın
        $role = Role::where('name', $request->input('role'))->first();
        
        // Rol id'si 1 veya 2 olmamalı
        if (in_array($role->id, [1, 2])) {
            return redirect()->back()->withErrors(['role' => 'Sie können diese Rolle nicht zuweisen.']);
        }
        $person->assignRole($role);
        
        return redirect()->route('persons')->with('success', 'Der Mitarbeiter wurde erfolgreich hinzugefügt.');
    }
    
    public function EditPerson($id)
    {
        // Oturum açmış kullanıcıyı alın
        $currentUser = Auth::user();
        
        // Düzenlenmek istenen kullanıcıyı bulun
        $user = User::findOrFail($id);
        
        // Eğer düzenlenmek istenen kullanıcının company_id'si oturum açmış kullanıcının company_id'sine eşit değilse
        if ($user->company_id !== $currentUser->company_id) {
            return redirect()->route('persons')->with('error', 'Sie sind nicht berechtigt, diesen Benutzer zu bearbeiten.');
        }
        
        // İd'si 1 ve 2 olmayan rolleri filtreleyin
        $roles = Role::whereNotIn('id', [1, 2])->get();
        
        return view('company.persons.edit-person', compact('user', 'roles'));
    }
    public function UpdatePerson(Request $request, $id)
    {
        // Oturum açmış kullanıcıyı alın
        $currentUser = Auth::user();
        
        // Güncellenmek istenen kullanıcıyı bulun
        $user = User::findOrFail($id);
        
        // Eğer güncellenmek istenen kullanıcı oturum açmış kullanıcıya bağlı değilse veya company_id null ise
        if ($user->company_id !== $currentUser->company_id || is_null($user->company_id)) {
            return redirect()->route('persons')->with('error', 'Sie sind nicht berechtigt, diesen Benutzer zu aktualisieren.');
        }
        
        // Kullanıcı bilgilerini güncelle
        $user->update([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
        ]);
        
        // Adres bilgilerini güncelle
        $address = [
            'country' => $request->input('country'),
            'city' => $request->input('city'),
            'street' => $request->input('street'),
            'zip_code' => $request->input('zip_code'),
            'address' => $request->input('address'),
        ];
        
        $user->update(['address' => json_encode($address)]);
        
        // Kullanıcının rolünü güncelle
        $role = Role::where('name', $request->input('role'))->first();
        
        // Belirli rollere izin verilmediğini kontrol edin
        if (in_array($role->id, [1, 2])) {
            return redirect()->route('persons')->with('error', 'Sie sind nicht berechtigt, diese Rolle zuzuweisen.');
        }
        
        $user->syncRoles([$role->id]);
        
        return redirect()->route('persons')->with('success', 'Der Mitarbeiter wurde erfolgreich aktualisiert.');
    }
    public function PersonDestroy($id)
    {
        // Oturum açmış kullanıcıyı alın
        $currentUser = Auth::user();
        
        // Silinmek istenen kullanıcıyı bulun
        $user = User::findOrFail($id);
        
        // Eğer silinmek istenen kullanıcı oturum açmış kullanıcıya bağlı değilse veya company_id null ise
        if ($user->company_id !== $currentUser->company_id || is_null($user->company_id)) {
            return redirect()->route('persons')->with('error', 'Sie sind nicht berechtigt, diesen Benutzer zu löschen.');
        }
        
        // Kullanıcıyı sil
        $user->delete();
        
        return redirect()->route('persons')->with('success', 'Der Mitarbeiter wurde erfolgreich gelöscht.');
    }
    public function PersonEditPassword(Request $request, $id)
    {
        // Oturum açmış kullanıcıyı alın
        $currentUser = Auth::user();
        
        // Güncellenmek istenen kullanıcıyı bulun
        $user = User::findOrFail($id);
        
        // Eğer güncellenmek istenen kullanıcı oturum açmış kullanıcıya bağlı değilse veya company_id null ise
        if ($user->company_id !== $currentUser->company_id || is_null($user->company_id)) {
            return redirect()->route('persons')->with('error', 'Sie sind nicht berechtigt, das Passwort dieses Benutzers zu ändern.');
        }
        
        // Şifre değiştirme işlemi için gerekli doğrulamaları yapın
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        
        // Yeni şifreyi güncelle
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
        
        return redirect()->route('persons')->with('success', 'Das Passwort des Mitarbeiters wurde erfolgreich geändert.');
    }
    public function SignPerson(Request $request, $id)
    {
        // Formdan gelen imza verisi (Base64 formatında)
        // İmza verisini al ve kaydet
        $signatureData = $request->input('signature');
        
        // İmza verisinin formatını kontrol et
        if (strpos($signatureData, 'base64,') !== false) {
            $imageData = explode('base64,', $signatureData)[1];
            $imageData = base64_decode($imageData);
            
            if ($imageData === false) {
                return redirect()->back()->withErrors(['signature' => 'Geçersiz imza verisi.']);
            }
        } else {
            return redirect()->back()->withErrors(['signature' => 'Geçersiz imza formatı.']);
        }
        
        $fileName = 'signature_' . time() . '.png';
        $directory = public_path('assets/images/signatures');
        
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        $filePath = $directory . '/' . $fileName;
        file_put_contents($filePath, $imageData);
        $signaturePath = 'assets/images/signatures/' . $fileName;
        
        // Kullanıcıyı ID'ye göre bul
        $user = User::findOrFail($id);
        
        // İmzayı veritabanına kaydet (örneğin `signature` alanı)
        $user->signature = $signaturePath;
        
        // Kullanıcıyı kaydet
        $user->save();
        
        // Başarılı işlemden sonra bir geri bildirim ver
        return redirect()->back()->with('success', 'Signature saved successfully!');
    }
    public function approveUser($id)
    {
        $user = User::find($id);
        
        // Kullanıcıyı yapan kullanıcının rolünü ve company_id'sini kontrol edelim
        $currentUser = Auth::user();
        if ($currentUser->role == 'Şirket Admin' || $currentUser->hasPermissionTo('Çalışan Onaylama')) {
            if ($user && $user->company_id == $currentUser->company_id) {
                $user->status = 1;
                $user->save();
                return redirect()->back()->with('success', 'Der Mitarbeiter wurde erfolgreich genehmigt.');
            } else {
                return redirect()->back()->with('error', 'Sie sind nicht berechtigt, diese Aktion auszuführen, oder es wurde auf einen ungültigen Mitarbeiter zugegriffen.');
            }
        } else {
            return redirect()->back()->with('error', 'Sie sind nicht berechtigt, diese Aktion durchzuführen.');
        }
    }
}
