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
        $suratMasuks = [
            [
                'id_dokumen' => 'DOK01',
                'pengirim_surat' => 'Kementerian Keuangan',
            ],
            [
                'id_dokumen' => 'DOK02',
                'pengirim_surat' => 'Perusahaan Partner',
            ],
            [
                'id_dokumen' => 'DOK03',
                'pengirim_surat' => 'Auditor Internal',
            ]
        ];

        foreach ($suratMasuks as $suratMasuk) {
            DB::table('surat_masuk')->updateOrInsert(
                ['id_dokumen' => $suratMasuk['id_dokumen']],
                array_merge($suratMasuk, [
                    'created_at' => now(),
                    'updated_at' => now()
                ])
            );
        }
    }
}
