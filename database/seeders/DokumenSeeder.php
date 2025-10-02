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
        $dokumens = [
            // Surat Masuk
            [
                'id_dokumen' => 'DOK01',
                'jenis_surat' => 'surat_masuk',
                'id_kategori' => 'KT001',
                'nama_dokumen' => 'Surat Keputusan Direktur',
                'no_dokumen' => 'SK/001/2025',
                'tahun' => 2025,
                'deskripsi' => 'Surat keputusan mengenai kebijakan perusahaan dari Kementerian Keuangan',
                'file_dokumen' => null,
                'file' => null, // Will be uploaded later
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_dokumen' => 'DOK02',
                'jenis_surat' => 'surat_masuk',
                'id_kategori' => 'KT002',
                'nama_dokumen' => 'Proposal Kerja Sama',
                'no_dokumen' => 'PKS/002/2025',
                'tahun' => 2025,
                'deskripsi' => 'Proposal kerja sama dari perusahaan partner',
                'file_dokumen' => null,
                'file' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_dokumen' => 'DOK03',
                'jenis_surat' => 'surat_masuk',
                'id_kategori' => 'KT003',
                'nama_dokumen' => 'Laporan Audit Sistem',
                'no_dokumen' => 'LAS/003/2025',
                'tahun' => 2025,
                'deskripsi' => 'Laporan audit sistem dari auditor internal',
                'file_dokumen' => null,
                'file' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Surat Keluar
            [
                'id_dokumen' => 'DOK04',
                'jenis_surat' => 'surat_keluar',
                'id_kategori' => 'KT001',
                'nama_dokumen' => 'Pemberitahuan Kebijakan Baru',
                'no_dokumen' => 'PKB/004/2025',
                'tahun' => 2025,
                'deskripsi' => 'Pemberitahuan kebijakan baru perusahaan kepada seluruh karyawan',
                'file_dokumen' => null,
                'file' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_dokumen' => 'DOK05',
                'jenis_surat' => 'surat_keluar',
                'id_kategori' => 'KT002',
                'nama_dokumen' => 'Laporan Keuangan Bulanan',
                'no_dokumen' => 'LKB/005/2025',
                'tahun' => 2025,
                'deskripsi' => 'Laporan keuangan bulanan untuk direktur utama',
                'file_dokumen' => null,
                'file' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id_dokumen' => 'DOK06',
                'jenis_surat' => 'surat_keluar',
                'id_kategori' => 'KT003',
                'nama_dokumen' => 'Kontrak Kerja Karyawan Baru',
                'no_dokumen' => 'KK/006/2025',
                'tahun' => 2025,
                'deskripsi' => 'Kontrak kerja untuk karyawan baru',
                'file_dokumen' => null,
                'file' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Dokumen Umum (tanpa jenis surat)
            [
                'id_dokumen' => 'DOK07',
                'jenis_surat' => null,
                'id_kategori' => 'KT004',
                'nama_dokumen' => 'Spesifikasi Teknis Sistem',
                'no_dokumen' => 'STS/007/2025',
                'tahun' => 2025,
                'deskripsi' => 'Spesifikasi teknis untuk pengembangan sistem e-Arsip',
                'file_dokumen' => null,
                'file' => null,
            ]
        ];

        foreach ($dokumens as $dokumen) {
            DB::table('dokumen')->updateOrInsert(
                ['id_dokumen' => $dokumen['id_dokumen']],
                array_merge($dokumen, [
                    'created_at' => now(),
                    'updated_at' => now()
                ])
            );
        }
    }
}
