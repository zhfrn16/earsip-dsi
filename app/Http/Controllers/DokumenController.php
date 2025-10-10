<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    /**
     * Generate next available document ID
     */
    private function generateNextId()
    {
        // Get all existing IDs and find the highest number
        $existingIds = Dokumen::pluck('id_dokumen')
            ->filter(function($id) {
                return preg_match('/^DOK\d+$/', $id);
            })
            ->map(function($id) {
                return intval(substr($id, 3));
            })
            ->sort()
            ->values();

        if ($existingIds->isEmpty()) {
            return 'DOK01';
        }

        $nextNumber = $existingIds->max() + 1;

        // Format as DOK + zero-padded number
        return 'DOK' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
    }

    public function index(Request $request)
    {
        $query = Dokumen::with(['kategori', 'suratMasuk', 'suratKeluar']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('id_dokumen', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('nama_dokumen', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('no_dokumen', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('kategori', function($q) use ($searchTerm) {
                      $q->where('nama_kategori', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        // Filter by category
        if ($request->has('kategori') && !empty($request->kategori)) {
            $query->where('id_kategori', $request->kategori);
        }

        // Filter by document type
        if ($request->has('jenis_surat') && !empty($request->jenis_surat)) {
            $query->where('jenis_surat', $request->jenis_surat);
        }

        // Filter by year
        if ($request->has('tahun') && !empty($request->tahun)) {
            $query->where('tahun', $request->tahun);
        }

        $dokumens = $query->orderBy('created_at', 'desc')->get();
        $kategoris = Kategori::all();
        $years = Dokumen::distinct()->pluck('tahun')->sort()->values();

        // Ensure we always have collections, even if empty
        $dokumens = $dokumens ?: collect();
        $kategoris = $kategoris ?: collect();
        $years = $years ?: collect();

        return view('dokumen.index', compact('dokumens', 'kategoris', 'years'));
    }

    public function create()
    {
        $kategoris = Kategori::all();

        // Ensure we always have a collection, even if empty
        $kategoris = $kategoris ?: collect();

        // Get next available ID for preview
        $nextId = $this->generateNextId();

        return view('dokumen.create', compact('kategoris', 'nextId'));
    }

    public function store(Request $request)
    {
        $rules = [
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'nama_dokumen' => 'required|string|max:100',
            'no_dokumen' => 'required',
            'tahun' => 'required|integer',
            'deskripsi' => 'nullable',
            'file' => 'nullable|file|mimes:pdf|max:10240', // Max 10MB
            'jenis_surat' => 'nullable|in:surat_masuk,surat_keluar',
        ];

        if ($request->input('jenis_surat') === 'surat_masuk') {
            $rules['pengirim_surat'] = 'required|string|max:255';
        } elseif ($request->input('jenis_surat') === 'surat_keluar') {
            $rules['tujuan_surat'] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);

        // Generate next document ID with retry logic for race conditions
        do {
            $validated['id_dokumen'] = $this->generateNextId();
            $exists = Dokumen::where('id_dokumen', $validated['id_dokumen'])->exists();
        } while ($exists);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $validated['id_dokumen'] . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('dokumen', $fileName, 'public');
            $validated['file'] = $filePath;
        }

        // Create Dokumen
        $dokumen = Dokumen::create($validated);

        // Create related SuratMasuk or SuratKeluar
        if ($validated['jenis_surat'] === 'surat_masuk') {
            SuratMasuk::create([
            'id_dokumen' => $dokumen->id_dokumen,
            'pengirim_surat' => $validated['pengirim_surat'],
            ]);
        } elseif ($validated['jenis_surat'] === 'surat_keluar') {
            SuratKeluar::create([
            'id_dokumen' => $dokumen->id_dokumen,
            'tujuan_surat' => $validated['tujuan_surat'],
            ]);
        }

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil ditambahkan');
    }

    public function edit($id_dokumen)
    {
        $dokumen = Dokumen::with(['suratMasuk', 'suratKeluar'])->findOrFail($id_dokumen);
        $kategoris = Kategori::all();

        // Ensure we always have a collection, even if empty
        $kategoris = $kategoris ?: collect();

        return view('dokumen.edit', compact('dokumen', 'kategoris'));
    }

    public function update(Request $request, $id_dokumen)
    {
        $dokumen = Dokumen::findOrFail($id_dokumen);

        $rules = [
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'nama_dokumen' => 'required|string|max:100',
            'no_dokumen' => 'required',
            'tahun' => 'required|integer',
            'deskripsi' => 'nullable',
            'file' => 'nullable|file|mimes:pdf|max:10240', // Max 10MB
            'jenis_surat' => 'nullable|in:surat_masuk,surat_keluar',
        ];

        if ($request->input('jenis_surat') === 'surat_masuk') {
            $rules['pengirim_surat'] = 'required|string|max:255';
        } elseif ($request->input('jenis_surat') === 'surat_keluar') {
            $rules['tujuan_surat'] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($dokumen->file && Storage::disk('public')->exists($dokumen->file)) {
                Storage::disk('public')->delete($dokumen->file);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $dokumen->id_dokumen . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('dokumen', $fileName, 'public');
            $validated['file'] = $filePath;
        }

        // Update Dokumen
        $dokumen->update($validated);        // Update or create related SuratMasuk or SuratKeluar
        if ($validated['jenis_surat'] === 'surat_masuk') {
            // Delete existing SuratKeluar if any
            $dokumen->suratKeluar()->delete();

            // Update or create SuratMasuk
            $dokumen->suratMasuk()->updateOrCreate(
                ['id_dokumen' => $dokumen->id_dokumen],
                ['pengirim_surat' => $validated['pengirim_surat']]
            );
        } elseif ($validated['jenis_surat'] === 'surat_keluar') {
            // Delete existing SuratMasuk if any
            $dokumen->suratMasuk()->delete();

            // Update or create SuratKeluar
            $dokumen->suratKeluar()->updateOrCreate(
                ['id_dokumen' => $dokumen->id_dokumen],
                ['tujuan_surat' => $validated['tujuan_surat']]
            );
        } else {
            // If jenis_surat is null or empty, delete both related records
            $dokumen->suratMasuk()->delete();
            $dokumen->suratKeluar()->delete();
        }

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diupdate');
    }

    public function destroy($id_dokumen)
    {
        $dokumen = Dokumen::findOrFail($id_dokumen);

        // Delete associated file if exists
        if ($dokumen->file && Storage::disk('public')->exists($dokumen->file)) {
            Storage::disk('public')->delete($dokumen->file);
        }

        // Delete related surat records
        $dokumen->suratMasuk()->delete();
        $dokumen->suratKeluar()->delete();

        $dokumen->delete();
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil dihapus');
    }

    /**
     * Download the specified file.
     */
    public function download($id_dokumen)
    {
        $dokumen = Dokumen::findOrFail($id_dokumen);

        if (!$dokumen->file || !Storage::disk('public')->exists($dokumen->file)) {
            abort(404, 'File tidak ditemukan');
        }

        $fileName = $dokumen->nama_dokumen . '.' . pathinfo($dokumen->file, PATHINFO_EXTENSION);
        $filePath = storage_path('app/public/' . $dokumen->file);

        return response()->download($filePath, $fileName);
    }

    /**
     * Display the specified file.
     */
    public function show($id_dokumen)
    {
        $dokumen = Dokumen::with(['kategori', 'suratMasuk', 'suratKeluar'])->findOrFail($id_dokumen);
        return view('dokumen.show', compact('dokumen'));
    }
}
