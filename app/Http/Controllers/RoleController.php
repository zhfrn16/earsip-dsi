<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_role' => 'required',
            'deskripsi' => 'nullable',
        ]);
        Role::create($request->all());
        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan');
    }

    public function edit($id_role)
    {
        $role = Role::findOrFail($id_role);
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $id_role)
    {
        $role = Role::findOrFail($id_role);
        $request->validate([
            'nama_role' => 'required',
            'deskripsi' => 'nullable',
        ]);
        $role->update($request->all());
        return redirect()->route('roles.index')->with('success', 'Role berhasil diupdate');
    }

    public function destroy($id_role)
    {
        $role = Role::findOrFail($id_role);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus');
    }
}
