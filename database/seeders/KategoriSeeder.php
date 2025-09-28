<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori')->insert([
            [
                'id_kategori' => 'KT001',
                'nama_kategori' => 'Dokumen Administratif',
                'deskripsi' => 'Dokumen administrasi dan surat-menyurat',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_kategori' => 'KT002',
                'nama_kategori' => 'Dokumen Keuangan',
                'deskripsi' => 'Dokumen laporan keuangan dan anggaran',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_kategori' => 'KT003',
                'nama_kategori' => 'Dokumen Legal',
                'deskripsi' => 'Dokumen hukum dan kontrak',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_kategori' => 'KT004',
                'nama_kategori' => 'Dokumen Teknis',
                'deskripsi' => 'Dokumen spesifikasi dan teknis',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_kategori' => 'KT005',
                'nama_kategori' => 'Dokumen Lainnya',
                'deskripsi' => 'Kategori dokumen lainnya',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
