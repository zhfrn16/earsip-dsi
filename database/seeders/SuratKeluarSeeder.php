<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuratKeluarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('surat_keluar')->insert([
            [
                'id_surat_keluar' => 'SK001',
                'id_dokumen' => 'DOK01',
                'id_user' => 1, // Admin user
                'file' => null,
                'no_surat' => 'SK/DIR/001/2025',
                'tanggal' => '2025-09-27 10:00:00',
                'sifat_surat' => 'Resmi',
                'pengirim' => 'Direktur Perusahaan',
                'perihal' => 'Kebijakan Baru Perusahaan',
                'tertuj' => 'Seluruh Karyawan',
                'alamat' => 'Kantor Pusat, Jakarta',
                'isi_surat' => 'Dengan ini kami sampaikan kebijakan baru yang berlaku mulai Oktober 2025.',
                'status' => 1,
                'status_persetujuan_staff' => true,
                'status_persetujuan_kadep' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_surat_keluar' => 'SK002',
                'id_dokumen' => 'DOK02',
                'id_user' => 2, // Operator user
                'file' => null,
                'no_surat' => 'SK/FIN/002/2025',
                'tanggal' => '2025-09-27 11:30:00',
                'sifat_surat' => 'Rahasia',
                'pengirim' => 'Manager Keuangan',
                'perihal' => 'Laporan Keuangan Bulanan',
                'tertuj' => 'Direktur Utama',
                'alamat' => 'Ruang Direktur, Lantai 10',
                'isi_surat' => 'Terlampir laporan keuangan untuk periode September 2025.',
                'status' => 0,
                'status_persetujuan_staff' => true,
                'status_persetujuan_kadep' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_surat_keluar' => 'SK003',
                'id_dokumen' => 'DOK03',
                'id_user' => 1, // Admin user
                'file' => null,
                'no_surat' => 'SK/HRD/003/2025',
                'tanggal' => '2025-09-27 14:15:00',
                'sifat_surat' => 'Biasa',
                'pengirim' => 'Manager HRD',
                'perihal' => 'Kontrak Kerja Karyawan Baru',
                'tertuj' => 'Calon Karyawan',
                'alamat' => 'Alamat Karyawan Bersangkutan',
                'isi_surat' => 'Selamat bergabung dengan perusahaan kami. Terlampir kontrak kerja yang harus ditandatangani.',
                'status' => 2,
                'status_persetujuan_staff' => true,
                'status_persetujuan_kadep' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
