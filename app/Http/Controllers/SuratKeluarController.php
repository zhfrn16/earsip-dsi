<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\Dokumen;
use App\Models\User;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $suratKeluar = SuratKeluar::with(['dokumen', 'user'])->latest()->get();
        return view('surat_keluar.index', compact('suratKeluar'));
    }

    public function create()
    {
        $dokumens = Dokumen::all();
        $users = User::all();
        return view('surat_keluar.create', compact('dokumens', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_surat_keluar' => 'required|unique:surat_keluar,id_surat_keluar',
            'id_dokumen' => 'required|exists:dokumen,id_dokumen',
            'id_user' => 'required|exists:users,id_user',
            'no_surat' => 'required',
            'tanggal' => 'required|date',
            'sifat_surat' => 'required',
            'pengirim' => 'required',
            'tertuj' => 'required',
            'perihal' => 'required',
            'isi_surat' => 'nullable',
            'file' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB
        ]);

        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path('file_arsip'), $fileName);
            $request->merge(['file' => $fileName]);
        }

        // Default approval status
        $request->merge([
            'status' => 0, // 0: Draft, 1: Approved, 2: Rejected
            'status_persetujuan_staff' => false,
            'status_persetujuan_kadep' => false,
        ]);

        SuratKeluar::create($request->all());
        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil ditambahkan');
    }

    public function edit($id_surat_keluar)
    {
        $suratKeluar = SuratKeluar::findOrFail($id_surat_keluar);
        $dokumens = Dokumen::all();
        $users = User::all();
        return view('surat_keluar.edit', compact('suratKeluar', 'dokumens', 'users'));
    }

    public function update(Request $request, $id_surat_keluar)
    {
        $suratKeluar = SuratKeluar::findOrFail($id_surat_keluar);

        $request->validate([
            'id_dokumen' => 'required|exists:dokumen,id_dokumen',
            'id_user' => 'required|exists:users,id_user',
            'no_surat' => 'required',
            'tanggal' => 'required|date',
            'sifat_surat' => 'required',
            'pengirim' => 'required',
            'tertuj' => 'required',
            'perihal' => 'required',
            'isi_surat' => 'nullable',
            'file' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB
        ]);

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($suratKeluar->file && file_exists(public_path('file_arsip/' . $suratKeluar->file))) {
                unlink(public_path('file_arsip/' . $suratKeluar->file));
            }

            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path('file_arsip'), $fileName);
            $request->merge(['file' => $fileName]);
        }

        $suratKeluar->update($request->all());
        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil diupdate');
    }

    public function destroy($id_surat_keluar)
    {
        $suratKeluar = SuratKeluar::findOrFail($id_surat_keluar);

        // Delete file if exists
        if ($suratKeluar->file && file_exists(public_path('file_arsip/' . $suratKeluar->file))) {
            unlink(public_path('file_arsip/' . $suratKeluar->file));
        }

        $suratKeluar->delete();
        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil dihapus');
    }

    /**
     * Approve surat keluar (only for staff or kadep)
     */
    public function approve($id_surat_keluar)
    {
        $suratKeluar = SuratKeluar::findOrFail($id_surat_keluar);
        $user = auth()->user();

        // Check role permission
        if ($user->id_role == 1) { // Admin/Kadep
            $suratKeluar->update([
                'status_persetujuan_kadep' => true,
                'status' => 1 // Approved
            ]);
            $message = 'Surat keluar berhasil disetujui oleh Kadep';
        } elseif ($user->id_role == 2) { // Staff
            $suratKeluar->update([
                'status_persetujuan_staff' => true,
                'status' => ($suratKeluar->status_persetujuan_kadep) ? 1 : 0 // Need both approvals
            ]);
            $message = 'Surat keluar berhasil disetujui oleh Staff';
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk approve surat');
        }

        return redirect()->route('surat-keluar.index')->with('success', $message);
    }

    /**
     * Reject surat keluar (only for staff or kadep)
     */
    public function reject($id_surat_keluar)
    {
        $suratKeluar = SuratKeluar::findOrFail($id_surat_keluar);
        $user = auth()->user();

        // Check role permission
        if ($user->id_role == 1 || $user->id_role == 2) { // Admin/Kadep or Staff
            $suratKeluar->update([
                'status' => 2, // Rejected
                'status_persetujuan_staff' => false,
                'status_persetujuan_kadep' => false,
            ]);
            return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil ditolak');
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk reject surat');
        }
    }
}
