<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller ini tidak digunakan untuk sistem e-Arsip
 * Dibiarkan untuk menjaga kompatibilitas route yang ada
 */
class BatchController extends Controller
{
    public function index()
    {
        return redirect()->route('dashboard')->with('info', 'Fitur batch tidak tersedia di sistem e-Arsip');
    }
    
    public function create()
    {
        return redirect()->route('dashboard')->with('info', 'Fitur batch tidak tersedia di sistem e-Arsip');
    }
    
    public function store(Request $request)
    {
        return redirect()->route('dashboard')->with('info', 'Fitur batch tidak tersedia di sistem e-Arsip');
    }
    
    public function edit($id)
    {
        return redirect()->route('dashboard')->with('info', 'Fitur batch tidak tersedia di sistem e-Arsip');
    }
    
    public function update(Request $request, $id)
    {
        return redirect()->route('dashboard')->with('info', 'Fitur batch tidak tersedia di sistem e-Arsip');
    }
    
    public function destroy($id)
    {
        return redirect()->route('dashboard')->with('info', 'Fitur batch tidak tersedia di sistem e-Arsip');
    }
}
