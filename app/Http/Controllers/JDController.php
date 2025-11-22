<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class JDController extends Controller
{
    private function generateNextId()
    {
        // Get all existing IDs and find the highest number
        $existingIds = Kategori::pluck('id_kategori')
            ->filter(function($id) {
                return preg_match('/^KT\d+$/', $id);
            })
            ->map(function($id) {
                return intval(substr($id, 2));
            })
            ->sort()
            ->values();

        if ($existingIds->isEmpty()) {
            return 'KT001';
        }

        $nextNumber = $existingIds->max() + 1;

        // Format as KT + zero-padded number
        return 'KT' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
    public function index()
    {
        $kategoris = Kategori::all();
        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        $nextId = $this->generateNextId();
        return view('kategori.create', compact('nextId'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_kategori' => 'required',
            'deskripsi' => 'nullable',
        ];


        $validated = $request->validate($rules);


         // Generate next document ID with retry logic for race conditions
        do {
            $validated['id_kategori'] = $this->generateNextId();
            $exists = Kategori::where('id_kategori', $validated['id_kategori'])->exists();
        } while ($exists);

        Kategori::create($validated);
        return redirect()->route('jenisDokumen.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);

        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'nullable',
        ]);

        $kategori->update($request->all());
        return redirect()->route('jenisDokumen.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id_kategori)
    {
        $kategori = Kategori::findOrFail($id_kategori);

        // Check if there are any documents associated with this category
        if ($kategori->dokumen()->exists()) {
            return redirect()->route('jenisDokumen.index')
            ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki dokumen terkait. Hapus semua dokumen terkait terlebih dahulu.');
        }

        $kategori->delete();
        return redirect()->route('jenisDokumen.index')->with('success', 'Kategori berhasil dihapus');
    }
}
