<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuratMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('surat_masuk')->insert([
            [
                'id_surat_masuk' => 'SM001',
                'id_dokumen' => 'DOK01',
                'id_user' => 1, // Admin user
                'file' => null,
                'no_surat' => 'SM/001/2025',
                'tanggal' => '2025-09-27 09:00:00',
                'sifat_surat' => 'Resmi',
                'pengirim' => 'Kementerian Keuangan',
                'perihal' => 'Pemberitahuan Perubahan Regulasi',
                'isi_surat' => 'Dengan hormat, kami sampaikan informasi perubahan regulasi terbaru yang berlaku.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_surat_masuk' => 'SM002',
                'id_dokumen' => 'DOK02',
                'id_user' => 2, // Operator user
                'file' => null,
                'no_surat' => 'SM/002/2025',
                'tanggal' => '2025-09-27 10:30:00',
                'sifat_surat' => 'Biasa',
                'pengirim' => 'Perusahaan Partner',
                'perihal' => 'Kerja Sama Bisnis',
                'isi_surat' => 'Proposal kerja sama untuk pengembangan sistem e-Arsip terintegrasi.',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_surat_masuk' => 'SM003',
                'id_dokumen' => 'DOK03',
                'id_user' => 1, // Admin user
                'file' => null,
                'no_surat' => 'SM/003/2025',
                'tanggal' => '2025-09-27 13:45:00',
                'sifat_surat' => 'Rahasia',
                'pengirim' => 'Auditor Internal',
                'perihal' => 'Laporan Audit Sistem',
                'isi_surat' => 'Hasil audit sistem arsip digital menunjukkan perlu adanya perbaikan keamanan.',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
