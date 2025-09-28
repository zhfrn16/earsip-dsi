<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dokumen')->insert([
            [
                'id_dokumen' => 'DOK01',
                'id_kategori' => 'KT001',
                'nama_dokumen' => 'Surat Keputusan Direktur',
                'no_dokumen' => 'SK/001/2025',
                'tahun' => 2025,
                'deskripsi' => 'Surat keputusan mengenai kebijakan perusahaan',
                'file_dokumen' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_dokumen' => 'DOK02',
                'id_kategori' => 'KT002',
                'nama_dokumen' => 'Laporan Keuangan Bulanan',
                'no_dokumen' => 'LKB/09/2025',
                'tahun' => 2025,
                'deskripsi' => 'Laporan keuangan untuk bulan September 2025',
                'file_dokumen' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_dokumen' => 'DOK03',
                'id_kategori' => 'KT003',
                'nama_dokumen' => 'Kontrak Kerja Karyawan',
                'no_dokumen' => 'KK/100/2025',
                'tahun' => 2025,
                'deskripsi' => 'Kontrak kerja untuk karyawan baru',
                'file_dokumen' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_dokumen' => 'DOK04',
                'id_kategori' => 'KT004',
                'nama_dokumen' => 'Spesifikasi Teknis Sistem',
                'no_dokumen' => 'STS/01/2025',
                'tahun' => 2025,
                'deskripsi' => 'Spesifikasi teknis untuk pengembangan sistem e-Arsip',
                'file_dokumen' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
