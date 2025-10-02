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
        $suratKeluars = [
            [
                'id_dokumen' => 'DOK04',
                'tujuan_surat' => 'Seluruh Karyawan',
            ],
            [
                'id_dokumen' => 'DOK05',
                'tujuan_surat' => 'Direktur Utama',
            ],
            [
                'id_dokumen' => 'DOK06',
                'tujuan_surat' => 'Calon Karyawan',
            ]
        ];

        foreach ($suratKeluars as $suratKeluar) {
            DB::table('surat_keluar')->updateOrInsert(
                ['id_dokumen' => $suratKeluar['id_dokumen']],
                array_merge($suratKeluar, [
                    'created_at' => now(),
                    'updated_at' => now()
                ])
            );
        }
    }
}
