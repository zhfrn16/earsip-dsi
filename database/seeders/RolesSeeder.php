<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'nama_role' => 'Administrator',
                'deskripsi' => 'Admin sistem dengan akses penuh',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_role' => 'Operator',
                'deskripsi' => 'Operator untuk input dan kelola data arsip',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_role' => 'User',
                'deskripsi' => 'User biasa dengan akses terbatas',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
