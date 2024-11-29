<?php

namespace App\Http\Controllers\Admin\Roller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function create()
    {
        $permissions = Permission::all();
        return view('new-role',compact('permissions'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|unique:roles,name',
        ]);
        
        $role = Role::create([
            'name' => $request->input('role_name'),
        ]);
    
        // Rol izinlerini ekle
        $role->permissions()->sync($request->input('permissions', []));
        
        return redirect()->route('roles')->with('success', 'Rol başarıyla oluşturuldu.');
    }
    public function edit($id)
    {
        // ID'si 1 olan rol için işlem yapılmasın
        if ($id == 1) {
            return redirect()->route('roles')->with('error', 'Bu rol üzerinde işlem yapılamaz.');
        }
    
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();
        return view('superadmin.user.edit-role', compact('role', 'permissions'));
    }
    
    public function update(Request $request, $id)
    {
        // ID'si 1 olan rol için işlem yapılmasın
        if ($id == 1) {
            return redirect()->route('roles')->with('error', 'Bu rol üzerinde işlem yapılamaz.');
        }
    
        $request->validate([
            'role_name' => 'required|string|unique:roles,name,'.$id,
        ]);
    
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->input('role_name'),
        ]);
    
        // İzinleri güncelle
        $role->permissions()->sync($request->input('permissions', []));
    
        return redirect()->route('roles')->with('success', 'Rol başarıyla güncellendi.');
    }
    
    public function destroy($id)
    {
        // ID'si 1 olan rol için işlem yapılmasın
        if ($id == 1) {
            return redirect()->route('roles')->with('error', 'Bu rol silinemez.');
        }
    
        $role = Role::findOrFail($id);
        $role->delete();
    
        return redirect()->route('roles')->with('success', 'Rol başarıyla silindi.');
    }
}
