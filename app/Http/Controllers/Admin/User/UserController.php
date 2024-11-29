<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function users()
    {
        $users = User::with('roles','company')->where('id', '!=', 1)->get();
        return view('superadmin.user.users', compact('users'));
    }
    
    public function roles()
    {
        $roles = Role::with('permissions')->where('id', '<>', 1)->get();
        return view('superadmin.user.roles', compact('roles'));
    }
    public function create()
    {
        $roles = Role::whereNotIn('id', [1])->get();
        $companys = Company::all();
        return view('superadmin.user.new-user', compact('roles', 'companys'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'company_id' => 'required|exists:companies,id', // Ensure company_id is provided and valid
        ]);
        
        $address = [
            'country' => $request->input('country'),
            'city' => $request->input('city'),
            'street' => $request->input('street'),
            'zip_code' => $request->input('zip_code'),
            'address' => $request->input('address'),
        ];
        
        $user = User::create([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'address' => json_encode($address),
            'company_id' => $request->input('company_id'), // Set the company_id
        ]);
        
        // Assign role to the user
        $role = Role::where('name', $request->input('role'))->first();
        $user->assignRole($role);
        
        return redirect()->route('users')->with('success', 'Kullanıcı başarıyla oluşturuldu.');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::with('permissions')->where('id', '<>', 1)->get();
        $companies = Company::all(); // Fetch all companies
        return view('superadmin.user.edit-user', compact('user', 'roles', 'companies'));
    }    
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Kullanıcı bilgilerini güncelle
        $user->update([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'company_id' => $request->input('company_id'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')), // Şifreyi güncelleyebilirsiniz, ancak şifreleme işlemini unutmayın
        ]);
        
        // Adres bilgilerini güncelle
        $address = [
            'country' => $request->input('country'),
            'city' => $request->input('city'),
            'county' => $request->input('county'),
            'district' => $request->input('district'),
            'street' => $request->input('street'),
            'zip_code' => $request->input('zip_code'),
            'address' => $request->input('address'),
        ];
        
        $user->update(['address' => json_encode($address)]);
        
        // Kullanıcının rolünü güncelle
        $role = Role::where('name', $request->input('role'))->first();
        $user->syncRoles([$role->id]);
        
        return redirect()->route('users')->with('success', 'Kullanıcı başarıyla güncellendi.');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return redirect()->route('users')->with('success', 'Kullanıcı başarıyla silindi.');
    }
    public function changePassword(Request $request, $id)
    {
        // Kullanıcı yetkilendirme kontrolü
        if (!Auth::user()->hasRole('Süper Admin')) {
            abort(403, 'Bu işlemi gerçekleştirmek için yetkiniz yok.');
        }
        else{
            
            $user = User::findOrFail($id);
            $request->validate([
                'new_password' => 'required|string|min:8|confirmed',
            ]);
            
            // Yeni şifreyi güncelle
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            
            return redirect()->route('users')->with('success', 'Şifre başarıyla değiştirildi.');
        }
        
    }
    public function approveUser($id)
    {
        $user = User::find($id);
        
        $user->status = 1;
        $user->save();
        return redirect()->back()->with('success', 'Kullanıcı Başarı ile Onaylandı');
        
    }

}
