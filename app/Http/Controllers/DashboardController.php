<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dokumen;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Kategori;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display dashboard with e-Arsip statistics.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalUser = User::count();
        $totalArsip = Dokumen::count();
        $totalSuratMasuk = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        $totalKategori = Kategori::count();

        return view('dashboard', compact(
            'totalUser',
            'totalArsip',
            'totalSuratMasuk',
            'totalSuratKeluar',
            'totalKategori'
        ));
    }

    /**
     * Show user list for admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function userList()
    {
        $users = User::with('role')->get();
        return view('userList', compact('users'));
    }
}
