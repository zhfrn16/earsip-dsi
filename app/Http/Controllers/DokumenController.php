<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Kategori;
use Illuminate\Http\Request;

class DokumenController extends Controller
{
    public function index()
    {
        $dokumens = Dokumen::with('kategori')->get();
        return view('dokumen.index', compact('dokumens'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('dokumen.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_dokumen' => 'required|unique:dokumen,id_dokumen',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'no_dokumen' => 'required',
            'tahun' => 'required|integer',
            'deskripsi' => 'nullable',
        ]);
        Dokumen::create($request->all());
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil ditambahkan');
    }

    public function edit($id_dokumen)
    {
        $dokumen = Dokumen::findOrFail($id_dokumen);
        $kategoris = Kategori::all();
        return view('dokumen.edit', compact('dokumen', 'kategoris'));
    }

    public function update(Request $request, $id_dokumen)
    {
        $dokumen = Dokumen::findOrFail($id_dokumen);
        $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'no_dokumen' => 'required',
            'tahun' => 'required|integer',
            'deskripsi' => 'nullable',
        ]);
        $dokumen->update($request->all());
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diupdate');
    }

    public function destroy($id_dokumen)
    {
        $dokumen = Dokumen::findOrFail($id_dokumen);
        $dokumen->delete();
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil dihapus');
    }
}
