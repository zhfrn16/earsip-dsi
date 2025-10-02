<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\Dokumen;
use App\Models\User;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    public function index()
    {
        $suratMasuk = SuratMasuk::with(['dokumen', 'user'])->latest()->get();
        return view('surat_masuk.index', compact('suratMasuk'));
    }

    public function create()
    {
        $dokumens = Dokumen::all();
        $users = User::all();
        return view('surat_masuk.create', compact('dokumens', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_surat_masuk' => 'required|unique:surat_masuk,id_surat_masuk',
            'id_dokumen' => 'required|exists:dokumen,id_dokumen',
            'id_user' => 'required|exists:users,id_user',
            'no_surat' => 'required',
            'tanggal' => 'required|date',
            'sifat_surat' => 'required',
            'pengirim' => 'required',
            'perihal' => 'required',
            'isi_surat' => 'nullable',
            'file' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB
        ]);

        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path('file_arsip'), $fileName);
            $request->merge(['file' => $fileName]);
        }

        SuratMasuk::create($request->all());
        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil ditambahkan');
    }

    public function edit($id_surat_masuk)
    {
        $suratMasuk = SuratMasuk::findOrFail($id_surat_masuk);
        $dokumens = Dokumen::all();
        $users = User::all();
        return view('surat_masuk.edit', compact('suratMasuk', 'dokumens', 'users'));
    }

    public function update(Request $request, $id_surat_masuk)
    {
        $suratMasuk = SuratMasuk::findOrFail($id_surat_masuk);

        $request->validate([
            'id_dokumen' => 'required|exists:dokumen,id_dokumen',
            'id_user' => 'required|exists:users,id_user',
            'no_surat' => 'required',
            'tanggal' => 'required|date',
            'sifat_surat' => 'required',
            'pengirim' => 'required',
            'perihal' => 'required',
            'isi_surat' => 'nullable',
            'file' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB
        ]);

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($suratMasuk->file && file_exists(public_path('file_arsip/' . $suratMasuk->file))) {
                unlink(public_path('file_arsip/' . $suratMasuk->file));
            }

            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path('file_arsip'), $fileName);
            $request->merge(['file' => $fileName]);
        }

        $suratMasuk->update($request->all());
        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil diupdate');
    }

    public function destroy($id_surat_masuk)
    {
        $suratMasuk = SuratMasuk::findOrFail($id_surat_masuk);

        // Delete file if exists
        if ($suratMasuk->file && file_exists(public_path('file_arsip/' . $suratMasuk->file))) {
            unlink(public_path('file_arsip/' . $suratMasuk->file));
        }

        $suratMasuk->delete();
        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil dihapus');
    }
}
