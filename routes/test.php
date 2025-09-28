<?php

use Illuminate\Support\Facades\Route;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\User;
use App\Models\Dokumen;

// Route untuk test database
Route::get('/test-database', function () {
    try {
        $suratMasuk = SuratMasuk::with(['dokumen', 'user'])->get();
        $suratKeluar = SuratKeluar::with(['dokumen', 'user'])->get();
        $users = User::with('role')->get();
        $dokumen = Dokumen::with('kategori')->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'surat_masuk_count' => $suratMasuk->count(),
                'surat_keluar_count' => $suratKeluar->count(),
                'users_count' => $users->count(),
                'dokumen_count' => $dokumen->count(),
                'sample_surat_masuk' => $suratMasuk->first(),
                'sample_surat_keluar' => $suratKeluar->first(),
                'sample_user' => $users->first(),
                'sample_dokumen' => $dokumen->first()
            ]
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

// Route untuk test sidebar role
Route::get('/test-sidebar', function () {
    // Mock authentication untuk testing
    $user = User::first();
    auth()->login($user);

    return view('layouts.sidebar');
})->name('test-sidebar');

// Route untuk test dashboard
Route::get('/test-dashboard', function () {
    $user = User::first();
    auth()->login($user);

    return app('App\Http\Controllers\DashboardController')->index();
})->name('test-dashboard');
