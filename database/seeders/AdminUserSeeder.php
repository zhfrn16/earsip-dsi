<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nama_lengkap' => 'Administrator System',
            'email' => 'admin@earsip.com',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'foto' => null,
            'id_role' => 1, // Administrator role
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'nama_lengkap' => 'Operator Test',
            'email' => 'operator@earsip.com',
            'username' => 'operator',
            'password' => Hash::make('operator123'),
            'foto' => null,
            'id_role' => 2, // Operator role
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
