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
        $roles = [
            [
                'nama_role' => 'Administrator',
                'deskripsi' => 'Admin sistem dengan akses penuh',
            ],
            [
                'nama_role' => 'Operator',
                'deskripsi' => 'Operator untuk input dan kelola data arsip',
            ],
            [
                'nama_role' => 'User',
                'deskripsi' => 'User biasa dengan akses terbatas',
            ]
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['nama_role' => $role['nama_role']],
                array_merge($role, [
                    'created_at' => now(),
                    'updated_at' => now()
                ])
            );
        }
    }
}
